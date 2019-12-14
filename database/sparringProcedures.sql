
DROP PROCEDURE IF EXISTS startSparring;
DROP PROCEDURE IF EXISTS resetSparringTable;
DROP PROCEDURE IF EXISTS repeatSparringTable;


delimiter $$

CREATE PROCEDURE startSparring(IN tableID INT, IN player1 INT, IN player2 INT, IN bestOf INT)
BEGIN
    DECLARE matchID INT DEFAULT 0;

START TRANSACTION;
-- create match
    INSERT INTO _match (player1ID, player2ID, bestOF, tableID)
    VALUES(player1, player2, bestOf, tableID);

-- get match id
    SELECT LAST_INSERT_ID() INTO matchID;

-- update table status and matchID
    UPDATE _table T SET T.status = "SparringOccupied", T.matchID = matchID
    WHERE T.id = tableID;

-- set match status to live
    UPDATE matchDetails MD SET MD.status = "Live"
    WHERE MD.matchID = matchID;

-- begin match with the first live frame
    INSERT INTO liveMatch(matchID, frameCounter, points1, points2, break1)
    VALUES(matchID, 1, 0, 0, 0);
COMMIT;
END;


-- reset table and stop match, invokes only for occupied && live
CREATE PROCEDURE resetSparringTable(IN tableID INT)
BEGIN
	DECLARE _matchID INT;

START TRANSACTION;

-- get matchID on this table
	SELECT T.matchID INTO _matchID
	FROM _table T
	WHERE T.id = tableID;

-- reset match status
	DELETE FROM matchDetails
	WHERE matchID = _matchID; 

-- reset match
	DELETE FROM _match
	WHERE id = _matchID;

-- reset live match
	DELETE FROM liveMatch
	WHERE matchID = _matchID;

	DELETE FROM frame
	WHERE matchID = _matchID;

	DELETE FROM break
	WHERE matchID = _matchID;

-- reset table status
	UPDATE _table T 
	SET T.matchID = NULL, T.status = "Available", T.youtube = NULL 
	WHERE T.id = tableID;

COMMIT;
END;



-- reset table and stop match, invokes only for occupied && live
CREATE PROCEDURE repeatSparringTable(IN tableID INT)
BEGIN
    DECLARE _matchID, player1, player2, bestOF INT;

START TRANSACTION;

-- get matchID on this table
    SELECT T.matchID, M.player1ID, M.player2ID, M.bestOf
    INTO _matchID, player1, player2, bestOF
    FROM _table T JOIN _match M ON T.matchID=M.id
    WHERE T.id = tableID;

-- create match
    INSERT INTO _match (player1ID, player2ID, bestOF, tableID)
    VALUES(player1, player2, bestOf, tableID);

-- get match id
    SELECT LAST_INSERT_ID() INTO _matchID;

-- update table status and matchID
    UPDATE _table T SET T.status = "SparringOccupied", T.matchID = _matchID
    WHERE T.id = tableID;

-- set match status to live
    UPDATE matchDetails MD SET MD.status = "Live"
    WHERE MD.matchID = _matchID;

-- begin match with the first live frame
    INSERT INTO liveMatch(matchID, frameCounter, points1, points2, break1)
    VALUES(_matchID, 1, 0, 0, 0);

COMMIT;
END;


$$
delimiter ;
