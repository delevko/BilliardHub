-- SAME ORDER

DROP PROCEDURE IF EXISTS seedPlayer;

DROP TRIGGER IF EXISTS finishTournament;

DROP PROCEDURE IF EXISTS getFirstGreaterPowerOf2;

delimiter $$


CREATE PROCEDURE seedPlayer(IN tournament INT, IN counter INT, IN rType VARCHAR(20), IN seed INT)
BEGIN
	DECLARE matchID, playerID INT DEFAULT -1;

	SELECT M.id INTO matchID
	FROM _match M WHERE M.tournamentID = tournament AND M.roundType = rType AND M.counter = counter;
	
	SELECT PT.playerID INTO playerID 
	FROM playerTournament PT
	WHERE PT.tournamentID = tournament AND PT.seed = seed;

	IF matchID != -1 THEN
		CALL putPlayerIntoMatch(matchID, playerID, 0);
	END IF;
END;




-- update ratings for finished tournament based on points in TournamentPoints
-- all points are provided b this time (after each match)
CREATE TRIGGER finishTournament AFTER UPDATE ON tournament
FOR EACH ROW 
BEGIN
    IF OLD.status != "Finished" AND NEW.status = "Finished" THEN
    -- update rating for each player
        UPDATE rating R INNER JOIN tournamentStandings TS ON R.playerID=TS.playerID
        SET R.points = R.points+TS.points WHERE R.leagueID=NEW.leagueID AND TS.tournamentID=NEW.id;
    END IF;
END;




-- HELPER for Players Counting
CREATE PROCEDURE getFirstGreaterPowerOf2 (INOUT X INT)
BEGIN
    DECLARE N INT DEFAULT 2;
    WHILE N < X DO
        SET N = N * 2;
    END WHILE;
    SET X = N;
END;
$$
delimiter ;



