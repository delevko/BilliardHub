DROP PROCEDURE IF EXISTS changePlayer;
DROP PROCEDURE IF EXISTS breakIncrement;
DROP PROCEDURE IF EXISTS updateHighestBreak;
DROP PROCEDURE IF EXISTS finishFrame;
DROP PROCEDURE IF EXISTS getBreakData;
DROP PROCEDURE IF EXISTS clearTable;

delimiter $$


CREATE PROCEDURE clearTable(IN tableID INT)
BEGIN
	START TRANSACTION;
		UPDATE _table T SET T.status="Available", T.matchID = NULL
		WHERE T.id=tableID;
	COMMIT;
END;



CREATE PROCEDURE getBreakData(IN matchID INT, IN xORy INT, INOUT player INT, INOUT opponent INT, INOUT frame INT, INOUT tournament INT)
BEGIN 
	SELECT LM.frameCounter INTO frame
	FROM liveMatch LM WHERE LM.matchID = matchID;

-- true: player1; false: player2;
	IF xORy THEN
		SELECT M.player1ID, M.tournamentID, M.player2ID
		INTO player, tournament, opponent
		FROM _match M WHERE M.id = matchID;
	ELSE
		SELECT M.player2ID, M.tournamentID, M.player1ID
		INTO player, tournament, opponent
		FROM _match M WHERE M.id = matchID;
	END IF;

END;



-- update highest break after match finishes
CREATE PROCEDURE updateHighestBreak(IN _break INT, IN playerID INT)
BEGIN
	DECLARE playerHighest INT DEFAULT 0;

 -- get general highest
	SELECT P.highestBreak INTO playerHighest
	FROM player P WHERE P.id = playerID;
	
 -- compare
	IF (_break > playerHighest) THEN
		UPDATE player P SET P.highestBreak = _break
		WHERE P.id = playerID;
	END IF;
END;



CREATE PROCEDURE changePlayer(IN tableID INT, IN isLeft BOOLEAN, IN _break INT)
BEGIN
    DECLARE break1, break2 INT DEFAULT 0;
    DECLARE player, opponent, frame, matchID, tournament INT DEFAULT 0;
    DECLARE tournamentBreak INT DEFAULT 0;
    DECLARE xORy BOOLEAN;

    SELECT T.matchID, Trn.minBreak INTO matchID, tournamentBreak
    FROM _table T
    LEFT JOIN _match M ON T.matchID=M.id
    LEFT JOIN tournament Trn ON M.tournamentID=Trn.id
    WHERE T.id = tableID;

START TRANSACTION;

    IF _break >= tournamentBreak THEN
        CALL getBreakData(matchID, !isLeft, player, opponent, frame, tournament);
        INSERT INTO break(XorY, points, frameCounter, playerID, opponentID, matchID, tournamentID)
        VALUES(!isLeft, _break, frame, player, opponent, matchID, tournament);

	CALL updateHighestBreak(_break, player);
    END IF;


    IF isLeft THEN
        SET break1 = 0; SET break2 = null;
    ELSE
        SET break1 = null; SET break2 = 0;
    END IF;

    UPDATE liveMatch LM SET LM.break1 = break1, LM.break2 = break2
    WHERE LM.matchID = (SELECT T.matchID FROM _table T where T.id=tableID);

COMMIT;
END;




CREATE PROCEDURE breakIncrement(IN tableID INT, IN isLeft BOOLEAN, IN pts INT)
BEGIN
START TRANSACTION;

	IF isLeft THEN
		UPDATE liveMatch LM SET LM.break1 = LM.break1+pts, 
		LM.points1 = LM.points1+pts
		WHERE LM.matchID = (SELECT T.matchID FROM _table T where T.id=tableID);
	ELSE
		UPDATE liveMatch LM SET LM.break2 = LM.break2+pts,
		LM.points2 = LM.points2+pts
		WHERE LM.matchID = (SELECT T.matchID FROM _table T where T.id=tableID);
	END IF;

COMMIT;
END;



CREATE PROCEDURE finishFrame(IN tableID INT)
BEGIN
	DECLARE points1, points2, matchID INT DEFAULT 0;
	DECLARE frameCounter INT DEFAULT 1;

START TRANSACTION;
	
	SELECT T.matchID INTO matchID
	FROM _table T WHERE T.id = tableID;

	SELECT LM.points1, LM.points2, LM.frameCounter 
	INTO points1, points2, frameCounter
	FROM liveMatch LM
	WHERE LM.matchID = matchID;

	IF points1 != points2 THEN	
		INSERT INTO frame(matchID, counter, points1, points2)
		VALUES(matchID, frameCounter, points1, points2);

		IF points1 > points2 THEN
			CALL scoreIncrement(true, tableID);
		ELSE
			CALL scoreIncrement(false, tableID);
		END IF;

		UPDATE liveMatch LM SET LM.points1=0, LM.points2=0, LM.break1=0, LM.break2=null, LM.frameCounter = frameCounter+1
			WHERE LM.matchID = matchID;
	END IF;

COMMIT;
END;


$$
delimiter ;

