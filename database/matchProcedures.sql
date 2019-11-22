
DROP PROCEDURE IF EXISTS getWinnerAndLoser;
DROP PROCEDURE IF EXISTS checkNextMatch;
DROP PROCEDURE IF EXISTS putPlayerIntoMatch;
DROP PROCEDURE IF EXISTS updateStandingsForPlayer;
DROP TRIGGER IF EXISTS finishMatch;
DROP TRIGGER IF EXISTS matchDetailsADD;

DROP PROCEDURE IF EXISTS clubTablesOccupy;
DROP PROCEDURE IF EXISTS occupyTable;
DROP PROCEDURE IF EXISTS occupyNext;
DROP PROCEDURE IF EXISTS getNextMatchForTable;
DROP PROCEDURE IF EXISTS beginMatch;
DROP PROCEDURE IF EXISTS finishMatch;

DROP PROCEDURE IF EXISTS setMatchTable;
DROP PROCEDURE IF EXISTS setMatchTableForOccupyAll;
DROP PROCEDURE IF EXISTS resetTable;

DROP PROCEDURE IF EXISTS checkIfAvailableMatchExists;
DROP PROCEDURE IF EXISTS getMinForRound;
DROP PROCEDURE IF EXISTS scoreIncrement;

DROP PROCEDURE IF EXISTS scoreCheck;
DROP TRIGGER IF EXISTS scoreTrigger;


delimiter $$

CREATE PROCEDURE scoreCheck(IN score1 INT, IN score2 INT, IN bestOf INT)
BEGIN
    IF score1*2-1 > bestOf THEN
        SIGNAL SQLSTATE '45000'
           SET MESSAGE_TEXT = 'check constraint on score1 failed';
    END IF;
    
    IF score2*2-1 > bestOf THEN
        SIGNAL SQLSTATE '45001'
           SET MESSAGE_TEXT = 'check constraint on score2 failed';
    END IF;

	IF score1*2 > bestOf AND score2*2 > bestOf THEN
        SIGNAL SQLSTATE '45002'
           SET MESSAGE_TEXT = 'check constraint on both scores failed';
	END IF;
END;


CREATE TRIGGER scoreTrigger AFTER UPDATE ON _match
FOR EACH ROW
BEGIN
	CALL scoreCheck(NEW.player1Score, NEW.player2Score, NEW.bestOF);
END;



-- when match is created, entry in matchDetails is added
CREATE TRIGGER matchDetailsADD AFTER INSERT ON _match
FOR EACH ROW
BEGIN
	INSERT INTO matchDetails(matchID, status) 
	VALUES(NEW.id, "Announced");
END;



-- when match is finished this procedure is invoked
CREATE PROCEDURE getWinnerAndLoser(INOUT winnerID INT, INOUT loserID INT, IN player1ID INT, IN player2ID INT, IN matchID INT)
BEGIN
	DECLARE pl1Score, pl2Score INT DEFAULT 0;

-- check for walkovers
	IF player2ID = -1 THEN
		SET winnerID = player1ID;
		SET loserID = player2ID;
	ELSEIF player1ID = -1 THEN
		SET winnerID = player2ID;
		SET loserID = player1ID;
-- now we have matches without walkovers, compare scores only
	ELSE
		SELECT player1Score, player2Score 
		INTO pl1Score, pl2Score
		FROM _match M WHERE M.id = matchID;

		IF pl2Score > pl1Score THEN
			SET winnerID = player2ID;
			SET loserID = player1ID;
		ELSE
			SET winnerID = player1ID;
			SET loserID = player2ID;
		END IF;
	END IF;
END;



-- put player into next match procedure
-- position: 1-first, 2-second, 0-check for first available
CREATE PROCEDURE putPlayerIntoMatch(IN nextMatchID INT, IN playerID INT, IN position INT)
BEGIN

-- put player into match (first OR first not empty)
	IF (position = 1 OR position = 0) AND 
		( EXISTS(SELECT m.player1ID FROM _match m WHERE m.id = nextMatchID AND m.player1ID = -2 LIMIT 1) )
	THEN
	-- put player into player1ID
		UPDATE _match m SET m.player1ID = playerID
			WHERE m.id = nextMatchID;

-- execute only if above was false
	ELSEIF( EXISTS(SELECT m.player2ID FROM _match m WHERE m.id = nextMatchID AND m.player2ID = -2 LIMIT 1) )
	THEN
	-- put player into player2ID
		UPDATE _match m SET m.player2ID = playerID 
			WHERE m.id = nextMatchID;
	END IF;
END;



-- update standings for loser
CREATE PROCEDURE updateStandingsForPlayer(IN tournamentID INT, IN playerID INT, IN places VARCHAR(20), IN roundNo INT, IN roundType VARCHAR(20))
BEGIN
	DECLARE points INT DEFAULT 0;

-- get player's points
	SELECT TP.points INTO points FROM tournamentPoints TP
	WHERE TP.tournamentID = tournamentID AND TP.lostInRoundNo = roundNo
		AND TP.lostInRoundType = roundType;

-- put player into standings
	INSERT INTO tournamentStandings (tournamentID, playerID, place, points)
	VALUES (tournamentID, playerID, places, points);
END;




-- check next match position for player (1 or 2)
CREATE PROCEDURE checkNextMatch(IN prvRndType VARCHAR(20), IN prvRndNo INT, IN prvCounter INT, IN nxtID INT, IN playerID INT)
BEGIN
	DECLARE nxtRndType VARCHAR(20) DEFAULT "";
	SELECT M.roundType INTO nxtRndType
	FROM _match M WHERE M.id = nxtID;

	IF prvRndType = "LOW" AND nxtRndType = "LOW" THEN
		IF prvRndNo%2 THEN
			CALL putPlayerIntoMatch(nxtID, playerID, 1);
		ELSE
			IF prvCounter%2 THEN
				CALL putPlayerIntoMatch(nxtID, playerID, 1);
			ELSE
				CALL putPlayerIntoMatch(nxtID, playerID, 2);
			END IF;
		END IF;

	ELSEIF prvRndType = "K/O" AND nxtRndType = "K/O" THEN
		IF prvCounter%2 THEN
			CALL putPlayerIntoMatch(nxtID, playerID, 1);
		ELSE
			CALL putPlayerIntoMatch(nxtID, playerID, 2);
		END IF;

	ELSEIF prvRndType = "UP" AND nxtRndType = "UP" THEN
		IF prvCounter%2 THEN
			CALL putPlayerIntoMatch(nxtID, playerID, 1);
		ELSE
			CALL putPlayerIntoMatch(nxtID, playerID, 2);
		END IF;
	
	ELSEIF prvRndType = "UP" AND nxtRndType = "K/O" THEN
		CALL putPlayerIntoMatch(nxtID, playerID, 1);
	
	END IF;
END;

-- trigger invoked only if match status is changed
-- TODO less computation in trigger
CREATE TRIGGER finishMatch AFTER UPDATE ON matchDetails
FOR EACH ROW
finish_label:BEGIN
-- matches
	DECLARE winnerMatchID, loserMatchID, roundNo, finalRound INT DEFAULT -1;
	DECLARE myCounter, winnerMatchCounter, loserMatchCounter, tournamentID INT DEFAULT -1;
	DECLARE roundType VARCHAR(20) DEFAULT "";
-- players
	DECLARE player1ID, player2ID INT DEFAULT -2;
	DECLARE player1Score, player2Score INT DEFAULT 0;
	DECLARE groupID INT DEFAULT 0;
	DECLARE winnerPlayerID, loserPlayerID INT DEFAULT -1;
	DECLARE winnerScore, loserScore INT DEFAULT 0;
	DECLARE loserPoints, winnerPoints DECIMAL(8,2) DEFAULT 0;
	DECLARE loserPlaces VARCHAR(20) DEFAULT "";
	DECLARE flag BOOLEAN DEFAULT true;
	
-- start match invokes only if both nonempty and nonwalkower
	IF OLD.status = "Announced" AND NEW.status = "Live" THEN
		UPDATE _match M SET M.player1Score = 0, M.player2Score = 0 
		WHERE M.id = NEW.matchID;

-- check if match was finished
-- invokes if walkover existed or when match has just been finished
	ELSEIF OLD.status != "Finished" AND NEW.status = "Finished" THEN
	
	-- get all data from _match
	-- TODO change winnerMatchID and loserMatchID into ID's,not counter
		SELECT M.counter, M.roundType, M.roundNo, M.player1ID, M.player2ID, M.tournamentID
		INTO myCounter, roundType, roundNo, player1ID, player2ID, tournamentID
		FROM _match M WHERE M.id = NEW.matchID;

		IF tournamentID IS NULL THEN
			LEAVE finish_label;
		END IF;


	-- update player group
		IF roundType = "Group" THEN
			SELECT M.player1Score, M.player2Score, M.groupID
			INTO player1Score, player2Score, groupID
			FROM _match M WHERE M.id = NEW.matchID;

			IF player1Score > player2Score THEN
				SET winnerPlayerID = player1ID;
				SET winnerScore = player1Score;
				SET loserPlayerID = player2ID;
				SET loserScore = player2Score;
			ELSE
				SET loserPlayerID = player1ID;
				SET loserScore = player1Score;
				SET winnerPlayerID = player2ID;
				SET winnerScore = player2Score;
			END IF;

			UPDATE playerGroup PG SET PG.mWon = PG.mWon+1,
			PG.fWon = PG.fWon+winnerScore, PG.fLost = PG.fLost+loserScore 
			WHERE PG.playerID = winnerPlayerID AND PG.groupID = groupID;
			
			UPDATE playerGroup PG SET PG.mLost = PG.mLost+1,
			PG.fLost = PG.fLost+winnerScore, PG.fWon = PG.fWon+loserScore 
			WHERE PG.playerID = loserPlayerID AND PG.groupID = groupID;

			SELECT EXISTS(
				SELECT 1 FROM matchView mv WHERE
        		mv.tournamentID = tournamentID AND 
				mv.status != "Finished" AND mv.roundType = "Group"
				LIMIT 1
			) INTO flag;
			IF !flag THEN
				CALL groupStandingsGenerate(tournamentID);
			END IF;
		ELSE

		-- get all match data	
			SELECT M.winnerMatchID, M.loserMatchID, M.loserPlaces
			INTO winnerMatchCounter, loserMatchCounter, loserPlaces
			FROM _match M WHERE M.id = NEW.matchID;

		-- getMatchIDs for counters
			SELECT M.id INTO winnerMatchID
			FROM _match M WHERE M.tournamentID=tournamentID AND M.counter=winnerMatchCounter AND M.roundType != "Group";
			SELECT M.id INTO loserMatchID
			FROM _match M WHERE M.tournamentID=tournamentID AND M.counter=loserMatchCounter AND M.roundType != "Group";
		
		-- get winnerPlayerID and loserPlayerID depending on walkovers OR score
			CALL getWinnerAndLoser(winnerPlayerID, loserPlayerID, player1ID, player2ID, NEW.matchID);

		-- put winner into next match
			CALL checkNextMatch(roundType, roundNo, myCounter, winnerMatchID, winnerPlayerID);

		-- if we are in LOW or KO update standings for losers
			IF loserPlayerID != -1 AND (roundtype = "LOW" OR roundType = "K/O")
			THEN
			-- update standings for loser
				CALL updateStandingsForPlayer(tournamentID, loserPlayerID, loserPlaces, roundNo, roundType);
		
		-- if we are in UP
			ELSEIF roundType = "UP" THEN
			-- put loserIntoNextMatch
				IF roundNo = 1 AND (myCounter%2) THEN
					CALL putPlayerIntoMatch(loserMatchID,loserPlayerID,1);
				ELSE
					CALL putPlayerIntoMatch(loserMatchID,loserPlayerID,2);
				END IF;
			END IF;
			
		-- if we are in Final
			SELECT t.KO_Rounds INTO finalRound FROM tournament t WHERE t.id=tournamentID;
			IF roundType = "K/O" AND roundNo = finalRound
			THEN
			-- update standings for winner
				CALL updateStandingsForPlayer(tournamentID, winnerPlayerID, "Place 1", roundNo+1, "K/O");

			-- finish the tournament (status->"Finished")
				UPDATE tournament t SET t.status = "Finished" WHERE t.id = tournamentID;
			END IF;
		END IF;
	END IF;
END;
$$

-- checks if available matches to play still exist
delimiter $$
CREATE PROCEDURE checkIfAvailableMatchExists(INOUT flag BOOLEAN, IN tournamentID INT)
BEGIN
-- get first nonempty match
    SELECT EXISTS (
		SELECT 1 FROM matchView mv WHERE
        mv.tournamentID = tournamentID AND mv.status = "Announced"
        AND mv.player1ID != -2 AND mv.player2ID != -2 LIMIT 1
	)
	INTO flag;
END;
$$
delimiter ;

-- get available minimum for specific roundType
delimiter $$
CREATE PROCEDURE getMinForRound(INOUT matchID INT, IN tournamentID INT, IN roundNo INT, IN roundType VARCHAR(20))
BEGIN 
	SELECT MV.matchID INTO matchID
	FROM matchView MV
	WHERE MV.tournamentID = tournamentID AND MV.roundType = roundType
		AND MV.roundNo = roundNo
		AND MV.matchID =
		(SELECT MIN(mv.matchID) FROM matchView mv 
		WHERE mv.tournamentID=tournamentID AND mv.status = "Announced"
		AND mv.player1ID != -2 AND mv.player2ID != -2 
		AND mv.roundNo=roundNo AND mv.roundType=roundType);
END;
$$
delimiter ;


-- finds first available match (only announced)
-- if no matches available matchID will be -1
delimiter $$
CREATE PROCEDURE getNextMatchForTable( INOUT matchID INT, IN tournamentID INT, IN tableNum INT )
myProc: BEGIN
	DECLARE flag BOOLEAN DEFAULT false;
	DECLARE i, UP_R, LOW_R, KO_R, G_R INT DEFAULT 0;
	CALL checkIfAvailableMatchExists(flag, tournamentID);
	
-- only if exists then find
	IF flag THEN
	-- check for all rounds in proper order
		SELECT T.UP_Rounds, T.LOW_Rounds, T.KO_Rounds, T.Group_Rounds
		INTO UP_R, LOW_R, KO_R, G_R FROM tournament T
		WHERE T.id = tournamentID;

	-- get max group players
		SELECT max(GT.nrOfPlayers) INTO G_R FROM groupTournament GT
		WHERE GT.tournamentID = tournamentID;
	-- if even -> group rounds = n-1; else -> n
		IF G_R%2 = 0 THEN
			SET G_R = G_R-1;
		END IF;

	-- GROUP
		SET i = 1;
		WHILE i <= G_R DO
			CALL getMinForRound(matchID, tournamentID, i, "Group");
			IF matchID != -1 THEN
				LEAVE myProc;
			END IF;
			SET i = i+1;
		END WHILE;

	-- UP 1 MIN
		CALL getMinForRound(matchID, tournamentID, 1, "UP");
		IF matchID != -1 THEN
			LEAVE myProc;
		END IF;

		SET i = 2;
		WHILE i <= UP_R DO
		-- UP i
			CALL getMinForRound(matchID, tournamentID, i, "UP");
			IF matchID != -1 THEN
				LEAVE myProc;
			END IF;
		-- LOW (i-1)*2 - 1
			CALL getMinForRound(matchID, tournamentID, (i-1)*2-1, "LOW");
			IF matchID != -1 THEN
				LEAVE myProc;
			END IF;
		-- LOW (i-1)*2
			CALL getMinForRound(matchID, tournamentID, (i-1)*2, "LOW");
			IF matchID != -1 THEN
				LEAVE myProc;
			END IF;
			SET i = i+1;
		END WHILE;

		SET i = 1;
		WHILE i <= KO_R DO
		-- K/O i
			CALL getMinForRound(matchID, tournamentID, i, "K/O");
			IF matchID != -1 THEN
				LEAVE myProc;
			END IF;
			SET i = i+1;
		END WHILE;
	END IF;
-- if flag was false-> do nothing since no games avaliable
END;
$$
delimiter ;

-- finish a match
delimiter $$
CREATE PROCEDURE finishMatch(IN _matchID INT)
BEGIN
-- set match status to finished
    UPDATE matchDetails MD SET MD.status = "Finished"
    WHERE MD.matchID = _matchID;

	DELETE FROM liveMatch WHERE matchID = _matchID;
END;
$$
delimiter ;

-- begin a match
delimiter $$
CREATE PROCEDURE beginMatch(IN matchID INT, IN tableID INT)
BEGIN
-- update table status and matchCounter
    UPDATE _table T SET T.status = "Occupied", T.matchID = matchID
    WHERE T.id = tableID;

-- update table number for _match
    UPDATE _match M SET M.tableID = tableID
    WHERE M.id = matchID;

-- set match status to live
    UPDATE matchDetails MD SET MD.status = "Live"
    WHERE MD.matchID = matchID;

	INSERT INTO liveMatch(matchID, frameCounter, points1, points2, break1)
	VALUES(matchID, 1, 0, 0, 0);
END;
$$
delimiter ;


-- start match for specific table via matchID(used inside mysql)
delimiter $$
CREATE PROCEDURE setMatchTableForOccupyAll( IN matchID INT, IN tableID INT, INOUT status VARCHAR(20) )
BEGIN
	DECLARE player1, player2 INT;

-- get both player ids	
	SELECT M.player1ID, M.player2ID 
	INTO player1, player2
	FROM _match M WHERE M.id = matchID;
	
-- check for walkovers
	IF player1 = -1 OR player2 = -1 THEN
	-- finish match immediately
		CALL finishMatch(matchID);
	ELSE
	-- begin if no walkovers
		CALL beginMatch(matchID, tableID);
		SET status = "Occupied";
	END IF;
END;
$$
delimiter ;


-- start match for specific table via matchID(called form frontend)
delimiter $$
CREATE PROCEDURE setMatchTable( IN matchID INT, IN tableID INT )
BEGIN
	DECLARE player1, player2 INT;

-- get both player ids	
	SELECT M.player1ID, M.player2ID 
	INTO player1, player2
	FROM _match M WHERE M.id = matchID;
	
-- check for walkovers
	IF player1 = -1 OR player2 = -1 THEN
	-- finish match immediately
		CALL finishMatch(matchID);
	ELSE
	-- begin if no walkovers
		CALL beginMatch(matchID, tableID);
	END IF;
END;
$$
delimiter ;


-- reset table and stop match, invokes only for occupied && live
delimiter $$
CREATE PROCEDURE resetTable(IN tableID INT)
BEGIN
	DECLARE _matchID INT;

START TRANSACTION;

-- get matchID on this table
	SELECT T.matchID INTO _matchID
	FROM _table T
	WHERE T.id = tableID;

-- reset match scores
	UPDATE _match M 
	SET M.player1Score=NULL, M.player2Score=NULL,
	M.tableID=NULL, M.youtube=NULL
	WHERE M.id = _matchID;

-- reset match status
	UPDATE matchDetails MD 
	SET MD.status = "Announced"
	WHERE MD.matchID = _matchID; 

-- reset live match
	DELETE FROM liveMatch
	WHERE matchID = _matchID;

	DELETE FROM frame
	WHERE matchID = _matchID;

	DELETE FROM break
	WHERE matchID = _matchID;

-- reset table status
	UPDATE _table T 
	SET T.matchID = NULL, T.status = "Available" 
	WHERE T.id = tableID;

COMMIT;
END;
$$
delimiter ;

-- procedure to occupy a specific table
delimiter $$
CREATE PROCEDURE occupyTable(IN tableID INT, INOUT flag BOOLEAN, IN tournamentID INT)
BEGIN
    DECLARE matchID INT DEFAULT -1;
    DECLARE tableStatus VARCHAR(20) DEFAULT "Available";
	DECLARE tableNum, clubID INT DEFAULT 0;

-- get table's status
    SELECT T.status, T._number, T.clubID
	INTO tableStatus, tableNum, clubID
    FROM _table T WHERE T.id = tableID;

-- if status was occupied then just exit this function and proceed to the next table
    WHILE tableStatus = "Available" DO
		SET matchID = -1;

    -- matchID is INOUT
        CALL getNextMatchForTable(matchID, tournamentID, tableNum);

    -- no matches available, break;
        IF matchID = -1
        THEN
            SET flag = FALSE;
            SET tableStatus = "Occupied";
    -- begin match, tableStatus doesn't change if was walkover
		ELSE
			CALL setMatchTableForOccupyAll(matchID, tableID, tableStatus);
        END IF;

    END WHILE;
END;
$$
delimiter ;

-- invokes only for occupied && finished
delimiter $$
CREATE PROCEDURE occupyNext(IN tableID INT, IN tournamentID INT)
BEGIN
	DECLARE flag BOOLEAN DEFAULT true;

-- reset table
	UPDATE _table T 
	SET T.status="Available", T.matchID = NULL 
	WHERE T.id = tableID;
	
-- set next match for table
	CALL occupyTable(tableID, flag, tournamentID);
END;
$$
delimiter ;

-- procedure to occupy all tables in a club
delimiter $$
CREATE PROCEDURE clubTablesOccupy(IN clubID INT, IN tournamentID INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE nrOfTables, tableID INT DEFAULT 0;
    DECLARE flag BOOLEAN DEFAULT true;

-- get number of all tables
    SELECT C.nrOfTables INTO nrOfTables 
	FROM club C WHERE C.id = clubID;

    WHILE i <= nrOfTables AND flag DO
    -- occupy each table
    -- flag - INOUT,if no available matches exist => flag=false; break;
        SELECT T.id INTO tableID 
		FROM _table T
		WHERE T.clubID = clubID AND T._number = i;

		CALL occupyTable(tableID, flag, tournamentID);
        SET i = i+1;
    END WHILE;
END;
$$
delimiter ;


-- procedure to increment Score and to finish match if score exceeds best of
delimiter $$
CREATE PROCEDURE scoreIncrement(IN firstIncrement BOOLEAN, IN tableID INT)
BEGIN
	DECLARE bestOf, player1Score, player2Score INT DEFAULT 0;
	DECLARE matchID INT DEFAULT 0;

	START TRANSACTION;

	SELECT T.matchID INTO matchID
	FROM _table T where T.id = tableID;

	SELECT M.bestOf, M.player1Score, M.player2Score
	INTO bestOf, player1Score, player2Score
	FROM _match M WHERE M.id = matchID;

	IF firstIncrement THEN
-- first player score increment
		UPDATE _match M SET M.player1Score=M.player1Score+1
		WHERE M.id = matchID;
		
		SET player1Score = player1Score+1;
	ELSE
-- second player score increment
		UPDATE _match M SET M.player2Score=M.player2Score+1
		WHERE M.id = matchID;
		
		SET player2Score = player2Score+1;
	END IF;


	IF player1Score*2 > bestOf OR player2Score*2 > bestOf THEN
		CALL finishMatch(matchID);
	END IF;

	COMMIT;
END;
$$
delimiter ;
