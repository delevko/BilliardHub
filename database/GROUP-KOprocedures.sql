-- SAME ORDER

DROP PROCEDURE IF EXISTS groupBaseGenerate;
DROP PROCEDURE IF EXISTS groupMatchesGenerate;
DROP PROCEDURE IF EXISTS groupSeedingGenerate;
DROP PROCEDURE IF EXISTS singleGroupMatchesGenerate;

DROP PROCEDURE IF EXISTS seedPlayerGroup;
DROP PROCEDURE IF EXISTS groupStandingsGenerate;
DROP PROCEDURE IF EXISTS singleGroupStandingsGenerate;
DROP PROCEDURE IF EXISTS afterGroupSeedingGenerate;
DROP PROCEDURE IF EXISTS tournamentStandingsAfterGroups;

DROP PROCEDURE IF EXISTS GroupKnockoutGenerate;

delimiter $$


CREATE PROCEDURE GroupKnockoutGenerate( IN id INT, IN groupMin INT, IN proceed INT, IN groupPlayers INT, IN N INT, IN seeded INT, IN KO_R INT, IN seeded_R INT, IN add_R INT, IN seeding VARCHAR(20) )
BEGIN
	DECLARE nrOfGroups, totalGroupProceed, groupMax INT DEFAULT 0;

	START TRANSACTION;
	
	SET nrOfGroups = FLOOR(groupPlayers/groupMin);
	SET totalGroupProceed = nrOfGroups * proceed;

	IF (groupPlayers MOD groupMin) = 0 THEN
		SET groupMax = groupMin;
	ELSE
		SET groupMax = groupMin + CEIL( (groupPlayers MOD groupMin)/nrOfGroups );
	END IF;

	CALL groupBaseGenerate(id,groupMin,proceed,groupPlayers,nrOfGroups,totalGroupProceed,N,seeded,KO_R,seeded_R,add_R);
    
	CALL KOMatchesGenerate(add_R, KO_R, seeded, N/2, id);

	CALL KOWinnersAndLosers(groupPlayers-totalGroupProceed,add_R,KO_R,seeded,N/2,id);
    
	IF seeded != 0 THEN
		CALL KOSeedingGenerate(id, "Standart", 0, seeded);
	END IF;

    CALL groupSeedingGenerate(id, seeding, seeded, groupPlayers);

    UPDATE tournament T SET T.bracket="GroupKO", 
	T.seeding=seeding WHERE T.id=id;

	COMMIT;
END;



-- HELPER FOR seed generation (for each player in a tournament)
CREATE PROCEDURE groupSeedingGenerate(IN tournamentID INT, IN seeding VARCHAR(20), IN myOffset INT, IN myLimit INT)
BEGIN
    DECLARE done BOOLEAN DEFAULT FALSE;
    DECLARE currSeed, currPlayer, pts INT DEFAULT 1;

-- cursor for standart seeding
    DECLARE StandartSeedCursor CURSOR FOR
    SELECT R.playerID, R.points FROM rating R
    WHERE R.leagueID =
        (SELECT T.leagueID FROM tournament T WHERE T.id = tournamentID)
    AND R.playerID IN
        (SELECT PT.playerID FROM playerTournament PT WHERE PT.tournamentID=tournamentID)
    ORDER BY points DESC LIMIT myOffset, myLimit;

-- cursor for random seeding
    DECLARE RandomSeedCursor CURSOR FOR
    SELECT R.playerID, R.points FROM rating R
    WHERE R.leagueID =
        (SELECT T.leagueID FROM tournament T WHERE T.id = tournamentID)
    AND R.playerID IN
        (SELECT PT.playerID FROM playerTournament PT WHERE PT.tournamentID=tournamentID)
    ORDER BY RAND() LIMIT myOffset, myLimit;
-- handler for loop continuation
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

-- seed players by rating in a loop for each registered
    IF(seeding = "Standart") THEN
        OPEN StandartSeedCursor;
        loop_seedUpdate: LOOP
            SET done = FALSE;

            FETCH StandartSeedCursor INTO currPlayer, pts;
            IF done THEN
                LEAVE loop_seedUpdate;
            END IF;
            INSERT INTO groupSeeding(tournamentID, playerID, seed)
			VALUES(tournamentID, currPlayer, currSeed);
            
			SET currSeed = currSeed+1;
        END LOOP;
        CLOSE StandartSeedCursor;

-- seed players randomly in a loop for each registered
    ELSEIF(seeding = "Random") THEN
        OPEN RandomSeedCursor;
        loop_seedUpdate: LOOP
            SET done = FALSE;

            FETCH RandomSeedCursor INTO currPlayer, pts;
            IF done THEN
                LEAVE loop_seedUpdate;
            END IF;
            INSERT INTO groupSeeding(tournamentID, playerID, seed)
			VALUES(tournamentID, currPlayer, currSeed);
            
            SET currSeed = currSeed+1;
        END LOOP;
		CLOSE RandomSeedCursor;
    END IF;
END;



CREATE PROCEDURE singleGroupStandingsGenerate(IN tournament INT, IN groupNum INT)
BEGIN
    DECLARE done BOOLEAN DEFAULT FALSE;
    DECLARE place INT DEFAULT 1;
    DECLARE playerID INT DEFAULT 0;
    DECLARE points DECIMAL(8,2) DEFAULT 0;

-- cursor for group standings
    DECLARE StandingsCursor CURSOR FOR
    SELECT PG.playerID, 
	ROUND(100*( (4/3)*PG.mWon/(PG.mWon+PG.mLost) + (2/3)*PG.fWon/(PG.fWon+PG.fLost) )/2 , 2)
		AS points
	FROM playerGroupView PG
    WHERE PG.tournamentID = tournament AND PG.groupNum = groupNum
    ORDER BY 2 DESC;

-- handler for loop continuation
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

-- create standings for players in pts order
	OPEN StandingsCursor;
	loop_standingUpdate: LOOP
		SET done = FALSE;

		FETCH StandingsCursor INTO playerID, points;
		IF done THEN
			LEAVE loop_standingUpdate;
		END IF;
		
		INSERT INTO groupStandings
			(tournamentID, playerID, groupPlace, groupNum, points)
		VALUES
			(tournament, playerID, place, groupNum, points);
		
		SET place = place+1;
	END LOOP;
	CLOSE StandingsCursor;

END;



-- HELPER FOR seed generation after groups
CREATE PROCEDURE afterGroupSeedingGenerate(IN tournamentID INT, IN groupProceed INT, IN offset INT)
BEGIN
    DECLARE done BOOLEAN DEFAULT FALSE;
    DECLARE currSeed, currPlayer, place, pts INT DEFAULT 1;
	DECLARE groupSeed INT DEFAULT 0;

-- cursor for standart seeding
    DECLARE StandartSeedCursor CURSOR FOR
	SELECT GS.playerID, GS.groupPlace, GS.points, GS.seed 
	FROM groupStandingsView GS
        WHERE GS.tournamentID=tournamentID
-- AND GS.groupPlace<=groupProceed
	ORDER BY 2, 3 DESC, 4;

-- handler for loop continuation
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	SET currSeed = offset+1;

-- seed players by rating in a loop for each registered
	OPEN StandartSeedCursor;
	loop_seedUpdate: LOOP
		SET done = FALSE;

		FETCH StandartSeedCursor INTO currPlayer, place, pts, groupSeed;
		IF done THEN
			LEAVE loop_seedUpdate;
		END IF;
		
		IF place <= groupProceed THEN
			UPDATE playerTournament PT SET PT.seed = currSeed
			WHERE PT.tournamentID=tournamentID AND PT.playerID=currPlayer;
			
			SET currSeed = currSeed+1;
		END IF;
	END LOOP;
	CLOSE StandartSeedCursor;
END;




CREATE PROCEDURE tournamentStandingsAfterGroups(IN id INT, IN grpMin INT, IN grpMax INT, IN proceed INT, IN n_grps INT, IN registered INT)
BEGIN
    DECLARE i, j, plrID, points, offset, counter INT DEFAULT 0;
    DECLARE place VARCHAR(20);

    SET offset = registered;

    SET i = grpMax;
    WHILE i > proceed DO
	SELECT count(GS.playerID) INTO counter FROM groupStandings GS
	WHERE GS.tournamentID = id AND GS.groupPlace = i;

	SET place = CONCAT("", offset-counter+1);
	SET place = CONCAT(place, "-");
	SET place = CONCAT(place, offset);

	SET j = 1;
	WHILE j <= n_grps DO
	    SET plrID = NULL;
	    SELECT GS.playerID INTO plrID FROM groupStandings GS
            WHERE GS.tournamentID = id AND GS.groupPlace = i
		AND GS.groupNum = j;

            SELECT TP.points INTO points FROM tournamentPoints TP
	    WHERE TP.tournamentID = id AND TP.lostInRoundNo=grpMax-i+1
		AND TP.lostInRoundType = "Group";

	    IF plrID IS NOT NULL THEN
		    INSERT INTO tournamentStandings
			(tournamentID,playerID,place,points)
		    VALUES(id, plrID, place, points);
	    END IF;

	    SET j = j+1;
	END WHILE;

        SET i = i-1;
	SET offset = offset - counter;
    END WHILE;

END;




CREATE PROCEDURE groupStandingsGenerate(IN tournament INT)
BEGIN
	DECLARE n_grps,grpProceed,seeded,grpPlrs,regPlrs INT DEFAULT 0;
	DECLARE grpMin, grpMax INT DEFAULT 0;
	DECLARE i INT DEFAULT 1;

	SELECT T.nrOfGroups, T.groupProceed, T.seededPlayers,
	T.groupMin, T.groupPlayers, T.registeredPlayers
	INTO n_grps, grpProceed, seeded, grpMin, grpPlrs, regPlrs
	FROM tournament T WHERE T.id = tournament;

	SET grpMax = grpMin + CEIL( (grpPlrs%grpMin) / n_grps);

	WHILE i <= n_grps DO 
		CALL singleGroupStandingsGenerate(tournament, i);
		SET i = i+1;
	END WHILE;

	CALL afterGroupSeedingGenerate(tournament, grpProceed, seeded);

	CALL tournamentStandingsAfterGroups(tournament,grpMin,grpMax,grpProceed,n_grps,regPlrs);

END;



CREATE PROCEDURE seedPlayerGroup(IN tournamentID INT, IN groupNo INT, IN playerSeed INT, IN playerNo INT)
BEGIN
	DECLARE groupID, playerID INT DEFAULT -1;

-- get this groupID
	SELECT GT.id INTO groupID FROM groupTournament GT
	WHERE GT.tournamentID = tournamentID AND GT.groupNum = groupNo;
-- get playerID 
	SELECT GS.playerID INTO playerID FROM groupSeeding GS
	WHERE GS.tournamentID = tournamentID AND GS.seed = playerSeed;

-- insert only if such seed exists
	IF playerID != -1 THEN
		INSERT INTO playerGroup(groupID, playerNum, playerID)
		VALUES (groupID, playerNo, playerID);
	END IF;
END;



-- HELPER to generateMatches for specific group
CREATE PROCEDURE singleGroupMatchesGenerate(IN tournamentID INT, IN groupNum INT, INOUT idx INT)
BEGIN
	DECLARE nrOfPlayers, groupID INT DEFAULT 0;
	DECLARE i, j INT DEFAULT 1;

-- get groupID and nr of players
	SELECT GT.id, GT.nrOfPlayers INTO groupID, nrOfPlayers FROM groupTournament GT
	WHERE GT.tournamentID = tournamentID AND GT.groupNum = groupNum;

	IF nrOfPlayers = 3 THEN
		CALL 3groupMatches(tournamentID, groupID, idx);
	ELSEIF nrOfPlayers = 4 THEN
		CALL 4groupMatches(tournamentID, groupID, idx);
	ELSEIF nrOfPlayers = 5 THEN
		CALL 5groupMatches(tournamentID, groupID, idx);
	ELSEIF nrOfPlayers = 6 THEN
		CALL 6groupMatches(tournamentID, groupID, idx);
	ELSEIF nrOfPlayers = 7 THEN
		CALL 7groupMatches(tournamentID, groupID, idx);
	ELSEIF nrOfPlayers = 8 THEN
		CALL 8groupMatches(tournamentID, groupID, idx);
	END IF;
END;



-- PROCEDURE to create groups
CREATE PROCEDURE groupMatchesGenerate(IN tournamentID INT, IN nrOfGroups INT)
BEGIN
	DECLARE i, idx INT DEFAULT 1;

-- generate matches (counter=idx - INOUT) for each group
	WHILE i <= nrOfGroups DO
		CALL singleGroupMatchesGenerate(tournamentID, i, idx);
		SET i = i+1;
	END WHILE;
END;



CREATE PROCEDURE groupBaseGenerate(IN id INT, IN groupMin INT, IN singleProceed INT, IN groupPlayers INT, IN nrOfGroups INT, IN totalGroupProceed INT, IN N INT, IN playersSeeded INT, IN KO_R INT, IN seeded_R INT, IN add_R INT)
BEGIN
	DECLARE i INT DEFAULT 1;

-- create 0 point entrys for players outside of our league
    INSERT INTO rating(leagueID, playerID, points)
    SELECT P.leagueID, P.playerID, 0
    FROM (SELECT @getVal := id) d, playersOutsideOfLeague P;


-- update all data
    UPDATE tournament T SET T.totalPlayers = N, T.seededPlayers = playersSeeded, 
		T.KO_Rounds = KO_R, T.seeded_Round = seeded_R,
        T.additional_Rounds = add_R, T.groupPlayers = groupPlayers, T.groupMin = groupMin,
		T.nrOfGroups = nrOfGroups, T.groupProceed = singleProceed,
		T.totalGroupProceed = totalGroupProceed
    WHERE T.id = id;

-- create base groups
	WHILE i <= nrOfGroups DO
	-- create group
		INSERT INTO groupTournament(tournamentID, groupNum)
		VALUES(id, i);
		SET i = i+1;
	END WHILE;
END;


$$
delimiter ;
