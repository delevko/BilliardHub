DROP PROCEDURE IF EXISTS changePlayer;
DROP PROCEDURE IF EXISTS breakIncrement;
DROP PROCEDURE IF EXISTS finishFrame;
DROP PROCEDURE IF EXISTS getBreakData;

delimiter $$

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


CREATE PROCEDURE changePlayer(IN tableID INT, IN isLeft BOOLEAN, IN _break INT)
BEGIN
	DECLARE break1, break2 INT DEFAULT 0;
	DECLARE player, opponent, frame, matchID, tournament INT DEFAULT 0;
	DECLARE xORy BOOLEAN;

	SELECT T.matchID INTO matchID
	FROM _table T WHERE T.id = tableID;

START TRANSACTION;

	IF _break >= 20 THEN
		CALL getBreakData(matchID, !isLeft, player, opponent, frame, tournament);
		INSERT INTO break(XorY, points, frameCounter, playerID, opponentID, matchID, tournamentID)
		VALUES(!isLeft, _break, frame, player, opponent, matchID, tournament);
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

