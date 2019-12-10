DROP PROCEDURE IF EXISTS changeSparringPlayer;
DROP PROCEDURE IF EXISTS getSparringBreakData;

delimiter $$


CREATE PROCEDURE changeSparringPlayer(IN tableID INT, IN isLeft BOOLEAN, IN _break INT)
BEGIN
    DECLARE break1, break2 INT DEFAULT 0;
    DECLARE player, opponent, frame, matchID INT DEFAULT 0;
    DECLARE xORy BOOLEAN;

    SELECT T.matchID INTO matchID 
    FROM _table T WHERE T.id = tableID;

START TRANSACTION;

    IF _break >= 40 THEN
        CALL getSparringBreakData(matchID, !isLeft, player, opponent, frame);
        INSERT INTO break(XorY, points, frameCounter, playerID, opponentID, matchID)
        VALUES(!isLeft, _break, frame, player, opponent, matchID);
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



CREATE PROCEDURE getSparringBreakData(IN matchID INT, IN xORy INT, INOUT player INT, INOUT opponent INT, INOUT frame INT)
BEGIN 
	SELECT LM.frameCounter INTO frame
	FROM liveMatch LM WHERE LM.matchID = matchID;

-- true: player1; false: player2;
	IF xORy THEN
		SELECT M.player1ID, M.player2ID
		INTO player, opponent
		FROM _match M WHERE M.id = matchID;
	ELSE
		SELECT M.player2ID, M.player1ID
		INTO player, opponent
		FROM _match M WHERE M.id = matchID;
	END IF;
END;


CREATE PROCEDURE rerack(IN tableID INT)
BEGIN
	DECLARE matchID, frameCnt INT;

START TRANSACTION;
	SELECT T.matchID INTO matchID
	FROM _table T WHERE T.id=tableID;

	IF matchID IS NOT NULL THEN
		UPDATE liveMatch SET points1=0, points2=0, break1=0, break2=null
		WHERE matchID = matchID;
	END IF;
COMMIT;

END;


$$
delimiter ;
