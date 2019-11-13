-- SAME ORDER
DROP PROCEDURE IF EXISTS RoundGenerate;
DROP PROCEDURE IF EXISTS WinnerIDGenerateForRound;
DROP PROCEDURE IF EXISTS LoserIDGenerateForRound;
DROP PROCEDURE IF EXISTS UP1toLOW1;

DROP PROCEDURE IF EXISTS LoserPlacesGenerateForRound;
DROP PROCEDURE IF EXISTS DoubleElimGenerate;
DROP PROCEDURE IF EXISTS DEBaseGenerate;

DROP PROCEDURE IF EXISTS firstRoundSeeding;

DROP PROCEDURE IF EXISTS DESeedingGenerate;


delimiter $$

-- PROCEDURE to generate ROUND in tournament
CREATE PROCEDURE RoundGenerate(INOUT begIdx INT, IN endIdx INT, IN RoundNo INT, IN RoundType VARCHAR(20), IN tournament INT)
BEGIN
    DECLARE player1, player2 INT;
    DECLARE i INT;

    SET i = begIdx;
    WHILE i < endIdx DO
		INSERT INTO _match(counter, tournamentID, player1ID, player2ID, bestOf, winnerMatchID, roundNo, roundType)
		VALUES(i, tournament, -2, -2, 3, -20, RoundNo, RoundType);

		SET i = i+1;
	END WHILE;
	SET begIdx = endIdx;
END;



-- PROCEDURE to fill WinnerMatchID's
CREATE PROCEDURE WinnerIDGenerateForRound(IN tournament INT, IN step INT, IN myID INT, IN myType VARCHAR(20), IN nextID INT, IN nextType VARCHAR(20))
BEGIN
	DECLARE i, N INT DEFAULT 1;
	DECLARE myMin, nextMin INT DEFAULT 1;
	DECLARE myCount, nextCount INT DEFAULT 1;

	SELECT my.counter, my.minimum, next.counter, next.minimum 
	INTO myCount, myMin, nextCount, nextMin
	FROM (SELECT COUNT(counter) AS counter, MIN(counter) AS minimum 
			FROM _match WHERE roundNo=myID
			AND roundType=myType AND tournamentID=tournament) AS my 
	JOIN 
		(SELECT COUNT(counter) AS counter, MIN(counter) AS minimum 
			FROM _match WHERE roundNo=nextID 
			AND roundType=nextType AND tournamentID=tournament) 
			AS next;

	WHILE i <= myCount DO
		UPDATE _match SET winnerMatchID = nextMin-1+CEIL(i/step), winnerMatchCounter = nextMin-1+CEIL(i/step)
		WHERE counter=(myMin-1+i) AND tournamentID=tournament AND roundType=myType;
		SET i = i+1;
	END WHILE;
END;



-- PROCEDURE to fill LoserMatchID's UPi->LOW(i-1)*2
CREATE PROCEDURE LoserIDGenerateForRound(IN tournament INT, IN myID INT)
BEGIN
	DECLARE i, myIdx, nextIdx, N INT DEFAULT 1;
	DECLARE myMin, nextMin INT DEFAULT 1;
	DECLARE myCount, nextCount INT DEFAULT 1;

	SELECT my.counter, my.minimum, next.counter, next.minimum 
	INTO myCount, myMin, nextCount, nextMin
	FROM (SELECT COUNT(counter) AS counter, MIN(counter) AS minimum 
			FROM _match WHERE roundNo=myID
			AND roundType="UP" AND tournamentID=tournament) AS my 
	JOIN 
		(SELECT COUNT(counter) AS counter, MIN(counter) AS minimum 
			FROM _match WHERE roundNo=(myID-1)*2 
			AND roundType="LOW" AND tournamentID=tournament) 
			AS next;

	IF myID != 3 THEN
		SET myIdx = myMin;
		SET nextIdx = nextMin + nextCount-1;
		WHILE myIdx <= myCount+myMin DO
			UPDATE _match SET loserMatchID = nextIdx, 
			loserMatchCounter = nextIdx
			WHERE counter=myIdx AND roundType="UP" 
			AND roundNo=myID AND tournamentID=tournament;
			
			SET myIdx = myIdx+1;
			SET nextIdx = nextIdx-1;
		END WHILE;
	
	ELSEIF myID = 3 THEN
		SET myIdx = myMin + myCount/2;
		SET nextIdx = nextMin + nextCount - 1;
		WHILE nextIdx >= nextMin DO
			UPDATE _match SET loserMatchID = nextIdx, 
			loserMatchCounter = nextIdx
			WHERE counter=myIdx AND roundType="UP" 
			AND roundNo=myID AND tournamentID=tournament;

			IF myIdx = myMin+myCount-1 THEN
				SET myIdx = myMin;
			ELSE
				SET myIdx = myIdx+1;
			END IF;
			SET nextIdx = nextIdx-1;
		END WHILE;
	END IF;
END;



-- PROCEDURE to fill LoserMatchID's UP1toLOW1
CREATE PROCEDURE UP1toLOW1(IN tournament INT, IN offset INT, IN N INT)
BEGIN
	DECLARE i INT DEFAULT 1;
	WHILE i <= N DO
		UPDATE _match SET loserMatchID = offset +FLOOR((i+1)/2), loserMatchCounter = offset+FLOOR((i+1)/2)
		WHERE counter=i AND roundType="UP" AND roundNo=1 AND tournamentID=tournament;
		SET i = i+1;
	END WHILE;
END;



-- PROCEDURE to fill LoserPlaces
CREATE PROCEDURE LoserPlacesGenerateForRound(IN N INT, IN tournID INT, IN myID INT, IN myType VARCHAR(20), IN offset INT)
BEGIN
	DECLARE myMin, myCount INT DEFAULT 0;
	DECLARE places VARCHAR(20) DEFAULT "";

	SELECT my.counter, my.minimum INTO myCount, myMin
	FROM (SELECT COUNT(counter) AS counter, MIN(counter) AS minimum 
			FROM _match WHERE roundNo=myID
			AND roundType=myType AND tournamentID=tournID) AS my; 

	SET places = CONCAT(places, (N - (myMin-offset-1) - myCount+1) );
	SET places = CONCAT(places, "-");
	SET places = CONCAT(places, (N - (myMin-offset-1)) );

	UPDATE _match SET loserPlaces = places
	WHERE roundNo=myID AND roundType=myType AND tournamentID=tournID;
END;



-- HELPER FOR seedind generation (for each player in a tournament)
CREATE PROCEDURE DESeedingGenerate( IN tournamentID INT, IN seeding VARCHAR(20) )
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
    ORDER BY points DESC;

-- cursor for random seeding
    DECLARE RandomSeedCursor CURSOR FOR
    SELECT R.playerID, R.points FROM rating R
    WHERE R.leagueID =
        (SELECT T.leagueID FROM tournament T WHERE T.id = tournamentID)
    AND R.playerID IN
        (SELECT PT.playerID FROM playerTournament PT WHERE PT.tournamentID=tournamentID)
    ORDER BY RAND();

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
            UPDATE playerTournament PT SET seed=currSeed
            WHERE PT.tournamentID=tournamentID AND PT.playerID = currPlayer;
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
            UPDATE playerTournament PT SET seed=currSeed
            WHERE PT.tournamentID=tournamentID AND PT.playerID = currPlayer;
            SET currSeed = currSeed+1;
        END LOOP;
            CLOSE RandomSeedCursor;
    END IF;
END;



-- PROCEDURE to seed first round tournament
CREATE PROCEDURE firstRoundSeeding(IN currRound INT, IN standart INT, IN myCounter INT, IN previous INT, IN N INT, IN tournament INT)
BEGIN
    DECLARE currCounter INT DEFAULT 0;
	DECLARE pl1ID, pl2ID INT DEFAULT -1;

    IF currRound > 1 THEN
        SET currCounter = N-N/POW(2,currRound-1)+myCounter;
        CALL firstRoundSeeding(currRound-1, standart, 2*myCounter-1, currCounter, N, tournament);
        CALL firstRoundSeeding(currRound-1, N/POW(2,currRound-1)-standart+1, 2*myCounter, currCounter, N, tournament);

    ELSEIF currRound = 1 THEN
		SELECT PT.playerID INTO pl1ID FROM playerTournament PT
		WHERE PT.seed = standart AND PT.tournamentID = tournament;
		SELECT PT.playerID INTO pl2ID FROM playerTournament PT
		WHERE PT.seed = N-standart+1 AND PT.tournamentID = tournament;

		UPDATE _match m SET m.player1ID = pl1ID, m.player2ID = pl2ID
		WHERE m.counter=myCounter AND m.tournamentID=tournament AND m.roundType="UP" AND m.roundNo=1;
    
	END IF;
END;



-- PROCEDURE to generate DoubleElimination tournament
CREATE PROCEDURE DEBaseGenerate(IN N INT, IN UP_R INT, IN UP_Total INT, IN LOW_R INT, IN LOW_Total INT, IN KO_N INT, IN tournament INT)
BEGIN
	DECLARE i, j, begIdx, step INT DEFAULT 1;

-- UPPER BRACKET matches
	SET i = 1;
	WHILE i <= UP_R DO
		CALL RoundGenerate(begIdx, begIdx+2*N/POW(2,i), i, "UP", tournament);
		SET i = i+1;
	END WHILE;

-- LOWER BRACKET matches
	SET i = 1;
	WHILE i <= LOW_R DO
		CALL RoundGenerate(begIdx, begIdx+N/POW(2, FLOOR((i+1)/2)), i, "LOW", tournament);
		SET i = i+1;
	END WHILE;

-- KNOCKOUT ROUND matches
	SET i = 1;
	WHILE i <= ( LOG(2,KO_N)+1 ) DO
		CALL RoundGenerate(begIdx, begIdx+2*KO_N/POW(2,i), i, "K/O", tournament);
		SET i = i+1;
	END WHILE;

-- UPPER BRACKET WinnerMatchIDs
	SET i = 1;
	WHILE i < UP_R DO
		CALL WinnerIDGenerateForRound(tournament, 2, i, "UP", i+1, "UP");
		SET i = i+1;
	END WHILE;
	CALL WinnerIDGenerateForRound(tournament, 1, UP_R, "UP", 1, "K/O");

-- LOWER BRACKET WinnerMatchIDs
	SET i = 1;
	WHILE i < LOW_R DO
		IF (i MOD 2) = 0 THEN
			SET step = 2;
		ELSE
			SET step = 1;
		END IF;

		CALL WinnerIDGenerateForRound(tournament, step, i, "LOW", i+1, "LOW");
		SET i = i+1;
	END WHILE;	

	CALL WinnerIDGenerateForRound(tournament, 1, LOW_R, "LOW", 1, "K/O");

-- KNOCKOUT ROUND WinnerMatchID's
	SET i = 1;
	WHILE i < ( LOG(2,KO_N)+1 ) DO
		CALL WinnerIDGenerateForRound(tournament, 2, i, "K/O", i+1, "K/O");
		SET i = i+1;
	END WHILE;

-- UPPER BRACKET LoserMatchID's
	CALL UP1toLOW1(tournament, UP_Total, N);
	SET i = 2;
	WHILE i <= UP_R DO
		CALL LoserIDGenerateForRound(tournament, i);
		SET i = i+1;
	END WHILE;

-- LOWER BRACKET LoserPlaces
	SET i = 1;
	WHILE i <= LOW_R DO
		CALL LoserPlacesGenerateForRound(2*N, tournament, i, "LOW", UP_Total);
		SET i = i+1;
	END WHILE;

-- KNOCKOUT ROUND LoserPlaces
	SET i = 1;
	WHILE i <= ( LOG(2,KO_N)+1 ) DO
		CALL LoserPlacesGenerateForRound(2*KO_N, tournament, i, "K/O", UP_Total+LOW_Total);
		SET i = i+1;
	END WHILE;

END;


CREATE PROCEDURE DoubleElimGenerate( IN id INT, IN N INT, IN LOW_R INT, IN UP_R INT, IN KO_R INT, IN KO_matches INT, IN seeding VARCHAR(20) )
BEGIN
	DECLARE LOW_total, UP_total INT DEFAULT 0;

	START TRANSACTION;

-- create 0 point entrys for players outside of our league
    INSERT INTO rating(leagueID, playerID, points)
    SELECT P.leagueID, P.playerID, 0
    FROM (SELECT @getVal := id) d, playersOutsideOfLeague P;

	SET N = N/2;
 	SET UP_total = 2*N - POW(2, LOG(2,N)+1-UP_R);
 	SET LOW_total = (UP_total-N) * 2;

-- update all data
    UPDATE tournament T SET T.totalPlayers = N*2, 
		T.KO_Rounds = KO_R, T.UP_Rounds = UP_R, T.LOW_Rounds = LOW_R, 
		T.UP_Total = UP_total, T.LOW_Total = LOW_total, T.KO_Matches = KO_matches
    WHERE T.id = id;

	CALL DEBaseGenerate(N, UP_R, UP_total, LOW_R, LOW_total, KO_matches, id);
	
	CALL DESeedingGenerate(id, seeding);
	
	UPDATE tournament T SET T.bracket="D/E", 
	T.seeding=seeding, T.KO_Matches=KO_matches WHERE T.id=id;

	COMMIT;
END;

$$
delimiter ;
