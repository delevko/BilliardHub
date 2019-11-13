-- SAME ORDER
DROP PROCEDURE IF EXISTS KOBaseGenerate;
DROP PROCEDURE IF EXISTS KOSeedingGenerate;
DROP PROCEDURE IF EXISTS KORoundGenerate;
DROP PROCEDURE IF EXISTS KOMatchesGenerate;
DROP PROCEDURE IF EXISTS KOWinnersAndLosers;
DROP PROCEDURE IF EXISTS KOsingleMatchWinnersAndLosers;
DROP PROCEDURE IF EXISTS KnockoutGenerate;


delimiter $$


CREATE PROCEDURE KnockoutGenerate(IN id INT, IN seeded INT, IN KO_R INT, IN add_R INT, IN seeded_R INT, IN N INT, IN seeding VARCHAR(20), IN registered INT)
BEGIN 

	START TRANSACTION;

    CALL KOBaseGenerate(id, seeded, KO_R, seeded_R, add_R, N);

    CALL KOMatchesGenerate(add_R, KO_R, seeded, N/2, id);
  
	CALL KOWinnersAndLosers(0, add_R, KO_R, seeded, N/2, id);
   
	CALL KOSeedingGenerate(id, seeding, 0, registered+seeded);

	UPDATE tournament T SET T.bracket="K/O", 
	T.seeding=seeding WHERE T.id=id;

	COMMIT;
END;



CREATE PROCEDURE KOSeedingGenerate(IN tournamentID INT, IN seeding VARCHAR(20), IN myOffset INT, IN myLimit INT)
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
            UPDATE playerTournament PT SET PT.seed = currSeed
			WHERE PT.tournamentID = tournamentID AND PT.playerID = currPlayer;

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
            UPDATE playerTournament PT SET PT.seed = currSeed
			WHERE PT.tournamentID = tournamentID AND PT.playerID = currPlayer;

            SET currSeed = currSeed+1;
        END LOOP;
        CLOSE RandomSeedCursor;
	END IF;
END;



CREATE PROCEDURE KORoundGenerate(IN begId INT, IN endId INT, IN rNo INT, IN Rtype VARCHAR(20), IN id INT)
BEGIN
	WHILE begId < endId DO 
		INSERT INTO _match (counter, tournamentID, roundNo, roundType)
		VALUES(begId, id, rNo, Rtype);

		SET begId = begId+1;
	END WHILE;
END;



CREATE PROCEDURE KOMatchesGenerate(IN add_R INT, IN KO_R INT, IN seeded INT, IN N INT, IN id INT)
BEGIN
	DECLARE counter, i, j INT DEFAULT 1;

	WHILE i <= add_R DO
		CALL KORoundGenerate(counter, counter+seeded, i, "K/O", id);
		SET counter = counter+seeded;
		SET i = i+1;
	END WHILE;

	SET j = add_R + 1;
	WHILE j <= KO_R DO
		CALL KORoundGenerate(counter, counter+N, j, "K/O", id);
		SET counter = counter+N;
		SET N = N/2;
		SET j = j+1;
	END WHILE;
END;


-- offset 0 for KO; lostInGroups for groups
CREATE PROCEDURE KOWinnersAndLosers(IN offset INT, IN add_R INT, IN KO_R INT, IN seeded INT, IN N INT, IN id INT)
BEGIN
	DECLARE counter, i, j, k, seeded_R INT DEFAULT 1;
	DECLARE places VARCHAR(20) DEFAULT "";

	SET seeded_R = add_R+1;

	WHILE i <= add_R DO
		SET places = "";
		SET places = CONCAT(places, seeded*2+(seeded_R-i-1)*seeded+1);
		SET places = CONCAT(places, "-");
		SET places = CONCAT(places, seeded*2+(seeded_R-i)*seeded);

		SET j = 1;
		WHILE j <= seeded DO
			CALL KOsingleMatchWinnersAndLosers(id, counter, counter+seeded, places);

			SET j = j+1; SET counter = counter+1;
		END WHILE;
		
		SET i = i+1;
	END WHILE;


	WHILE i <= KO_R DO
		SET places = "";
		SET places = CONCAT(places, N+1);
		SET places = CONCAT(places, "-");
		SET places = CONCAT(places, N*2);
		
		SET k = 0; SET j = 1;
		WHILE j <= N DO
			CALL KOsingleMatchWinnersAndLosers(id, counter, counter+N-FLOOR((k+1)/2), places);

			SET j = j+1; SET counter = counter+1;
			SET k = k+1;
		END WHILE;

		SET N = N/2; SET i = i+1;
	END WHILE;
END;



CREATE PROCEDURE KOsingleMatchWinnersAndLosers(IN id INT, IN myCounter INT, IN nextCounter INT, IN places VARCHAR(20))
BEGIN
	DECLARE myID, nextID INT DEFAULT 0;

	SELECT M.id INTO myID FROM _match M
	WHERE M.tournamentID = id AND M.counter = myCounter AND M.roundType = "K/O";
	SELECT M.id INTO nextID FROM _match M
	WHERE M.tournamentID = id AND M.counter = nextCounter AND M.roundType = "K/O";

	UPDATE _match M SET M.winnerMatchID = nextCounter, M.winnerMatchCounter = nextCounter, 
		M.loserPlaces = places WHERE M.id = myID;
END;



CREATE PROCEDURE KOBaseGenerate( IN id INT, IN playersSeeded INT, IN KO_R INT, IN seeded_R INT, IN add_R INT, IN N INT )
BEGIN

-- create 0 point entrys for players outside of our league
	INSERT INTO rating(leagueID, playerID, points) 
	SELECT P.leagueID, P.playerID, 0 
	FROM (SELECT @getVal := id) d, playersOutsideOfLeague P;	

-- update all data
	UPDATE tournament T SET T.totalPlayers = N, T.KO_Rounds = KO_R,
 		T.seededPlayers = playersSeeded, KO_Rounds = KO_R, seeded_Round = seeded_R,
		T.additional_Rounds = add_R
	WHERE T.id = id;

END;

$$
delimiter ;
