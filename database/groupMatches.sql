DROP PROCEDURE IF EXISTS 3groupMatches;
DROP PROCEDURE IF EXISTS 4groupMatches;
DROP PROCEDURE IF EXISTS 5groupMatches;
DROP PROCEDURE IF EXISTS 6groupMatches;
DROP PROCEDURE IF EXISTS 7groupMatches;
DROP PROCEDURE IF EXISTS 8groupMatches;

delimiter $$
CREATE PROCEDURE 3groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1,player2,player3 INT DEFAULT -1;
	DECLARE beastOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 3, "Group", groupID);
	SET idx = idx+1;
END;
$$
delimiter ;


delimiter $$
CREATE PROCEDURE 4groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1, player2, player3, player4 INT DEFAULT -1;
	DECLARE bestOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;
-- player4
	SELECT PG.playerID INTO player4 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 4;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player4, bestOF, 1, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player4, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player4, bestOF, 3, "Group", groupID);
	SET idx = idx+1;
END;
$$
delimiter ;


delimiter $$
CREATE PROCEDURE 5groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1,player2,player3,player4,player5 INT DEFAULT -1;
	DECLARE bestOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;
-- player4
	SELECT PG.playerID INTO player4 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 4;
-- player5
	SELECT PG.playerID INTO player5 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 5;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player5, bestOF, 1, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player4, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player5, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player4, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player4, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

-- ROUND 4
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player5, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

-- ROUND 5
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player5, bestOF, 5, "Group", groupID);
	SET idx = idx+1;
END;
$$
delimiter ;


delimiter $$
CREATE PROCEDURE 6groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1,player2,player3,player4,player5,player6 INT DEFAULT -1;
	DECLARE bestOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;
-- player4
	SELECT PG.playerID INTO player4 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 4;
-- player5
	SELECT PG.playerID INTO player5 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 5;
-- player6
	SELECT PG.playerID INTO player6 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 6;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player6, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player5, bestOF, 1, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player4, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player5, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player4, bestOF, 2, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player6, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player4, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 3, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player6, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

-- ROUND 4
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player6, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player5, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

-- ROUND 5
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player5, bestOF, 5, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player6, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

END;
$$
delimiter ;


delimiter $$
CREATE PROCEDURE 7groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1,player2,player3,player4,player5,player6,player7 INT DEFAULT -1;
	DECLARE bestOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;
-- player4
	SELECT PG.playerID INTO player4 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 4;
-- player5
	SELECT PG.playerID INTO player5 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 5;
-- player6
	SELECT PG.playerID INTO player6 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 6;
-- player7
	SELECT PG.playerID INTO player7 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 7;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player7, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player6, bestOF, 1, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player5, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player6, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player5, bestOF, 2, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player7, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player5, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player4, bestOF, 3, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player6, player7, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

-- ROUND 4
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player4, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player6, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player7, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

-- ROUND 5
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player4, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 5, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player6, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

-- ROUND 6
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 6, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player7, bestOF, 6, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player5, bestOF, 6, "Group", groupID);
	SET idx = idx+1;

-- ROUND 7
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 7, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player7, bestOF, 7, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player6, bestOF, 7, "Group", groupID);
	SET idx = idx+1;

END;
$$
delimiter ;



delimiter $$
CREATE PROCEDURE 8groupMatches(IN tournamentID INT, IN groupID INT, INOUT idx INT)
BEGIN
	DECLARE player1,player2,player3,player4,player5,player6,player7,player8 INT DEFAULT -1;
	DECLARE bestOF INT DEFAULT 3;
-- player1
	SELECT PG.playerID INTO player1 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 1;
-- player2
	SELECT PG.playerID INTO player2 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 2;
-- player3
	SELECT PG.playerID INTO player3 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 3;
-- player4
	SELECT PG.playerID INTO player4 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 4;
-- player5
	SELECT PG.playerID INTO player5 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 5;
-- player6
	SELECT PG.playerID INTO player6 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 6;
-- player7
	SELECT PG.playerID INTO player7 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 7;
-- player8
	SELECT PG.playerID INTO player8 FROM playerGroup PG
	WHERE PG.groupID = groupID AND PG.playerNum = 8;

-- ROUND 1
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player7, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player6, bestOF, 1, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player5, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player8, bestOF, 1, "Group", groupID);
	SET idx = idx+1;

-- ROUND 2
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player6, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player5, bestOF, 2, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player7, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player8, bestOF, 2, "Group", groupID);
	SET idx = idx+1;

-- ROUND 3
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player5, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player4, bestOF, 3, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player6, player7, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player8, bestOF, 3, "Group", groupID);
	SET idx = idx+1;

-- ROUND 4
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player4, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player6, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player7, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player8, bestOF, 4, "Group", groupID);
	SET idx = idx+1;

-- ROUND 5
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player4, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player3, bestOF, 5, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player6, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player7, player8, bestOF, 5, "Group", groupID);
	SET idx = idx+1;

-- ROUND 6
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player3, bestOF, 6, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player2, player7, bestOF, 6, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player5, bestOF, 6, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player6, player8, bestOF, 6, "Group", groupID);
	SET idx = idx+1;

-- ROUND 7
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player1, player2, bestOF, 7, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player3, player7, bestOF, 7, "Group", groupID);
	SET idx = idx+1;
	
	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player4, player6, bestOF, 7, "Group", groupID);
	SET idx = idx+1;

	INSERT INTO _match(counter,tournamentID,player1ID,player2ID,bestOF,roundNo,roundType,groupID)
	VALUES(idx, tournamentID, player5, player8, bestOF, 7, "Group", groupID);
	SET idx = idx+1;

END;
$$
delimiter ;
