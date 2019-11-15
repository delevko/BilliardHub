
DROP PROCEDURE IF EXISTS pointsInit;
DROP PROCEDURE IF EXISTS bestOfInit;

DROP PROCEDURE IF EXISTS roundPointsInit;
DROP PROCEDURE IF EXISTS roundBestOfInit;

DROP PROCEDURE IF EXISTS tournamentInput;


delimiter $$



CREATE PROCEDURE tournamentInput( IN id INT, IN minBreak INT,IN GR_pts VARCHAR(150),IN LOW_pts VARCHAR(150),IN KO_pts VARCHAR(150),IN GR_bestOF INT,IN LOW_bestOF VARCHAR(100),IN UP_bestOF VARCHAR(100),IN KO_bestOF VARCHAR(100) )
BEGIN

START TRANSACTION;

    CALL pointsInit(id, GR_pts, LOW_pts, KO_pts);

    CALL bestOfInit(id, GR_bestOF, LOW_bestOF, UP_bestOF, KO_bestOF);

    UPDATE tournament T SET T.minBreak = minBreak WHERE T.id = id;

    UPDATE tournament T SET T.status = "Live" WHERE T.id = id;

COMMIT;

END;



CREATE PROCEDURE bestOfInit(IN id INT, IN GR INT, IN LOW VARCHAR(100), IN UP VARCHAR(100), IN KO VARCHAR(100) )
BEGIN

    IF GR != -1 THEN
    	UPDATE _match M SET M.bestOF = GR
    	WHERE M.tournamentID = id AND M.roundType = "Group";
    END IF;

    CALL roundBestOfInit(id, "LOW", LOW);

    CALL roundBestOfInit(id, "UP", UP);

    CALL roundBestOfInit(id, "K/O", KO);

END;



CREATE PROCEDURE pointsInit(IN id INT, IN GR VARCHAR(150),
IN LOW VARCHAR(150), IN KO VARCHAR(150))
BEGIN

    CALL roundPointsInit(id, "Group", GR);

    CALL roundPointsInit(id, "LOW", LOW);

    CALL roundPointsInit(id, "K/O", KO);

END;



CREATE PROCEDURE roundBestOfInit(IN id INT, IN type VARCHAR(20), IN bestOf VARCHAR(100) )
BEGIN
    DECLARE rounds, b_of INT DEFAULT 0;
    DECLARE i INT;

    SET rounds = CONVERT(SUBSTRING_INDEX(bestOf, ":", 1), UNSIGNED);
    SET bestOf = SUBSTRING_INDEX(bestOf, ":", -1);

    SET i = 1;
    WHILE i <= rounds DO
        SET b_of = SUBSTRING_INDEX(bestOf, ",", 1);
        SET bestOf = SUBSTRING(bestOf, locate(",", bestOf)+1);

	UPDATE _match M SET M.bestOF = b_of
	WHERE M.tournamentID=id AND M.roundType=type AND M.roundNo=i;

        SET i = i+1;
    END WHILE;
END;



CREATE PROCEDURE roundPointsInit(IN id INT, IN type VARCHAR(20), IN points VARCHAR(150) )
BEGIN
    DECLARE rounds, pts INT DEFAULT 0;
    DECLARE i INT;

    SET rounds = CONVERT(SUBSTRING_INDEX(points, ":", 1), UNSIGNED);
    SET points = SUBSTRING_INDEX(points, ":", -1);

    SET i = 1;
    WHILE i <= rounds DO
        SET pts = SUBSTRING_INDEX(points, ",", 1);
        SET points = SUBSTRING(points, locate(",", points)+1);

        INSERT INTO tournamentPoints(tournamentID, lostInRoundNo,
	lostInRoundType, points)
	VALUES(id, i, type, pts);

        SET i = i+1;
    END WHILE;
END;


$$
delimiter ;
