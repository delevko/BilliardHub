-- SAME ORDER

DROP PROCEDURE IF EXISTS seedPlayer;

DROP TRIGGER IF EXISTS finishTournament;

DROP PROCEDURE IF EXISTS getFirstGreaterPowerOf2;

DROP PROCEDURE IF EXISTS resetBracket;
DROP PROCEDURE IF EXISTS deleteTournament;

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

    -- reset table youtubes, where this tournament took part in
	UPDATE _table T set T.youtube = NULL WHERE T.clubID = NEW.clubID;
    END IF;
END;


-- resets tournament to standby phase
CREATE PROCEDURE resetBracket(IN tournamentID INT)
BEGIN
START TRANSACTION;
-- match data
    DELETE B FROM break B WHERE B.tournamentID = tournamentID;

    DELETE LM FROM liveMatch LM WHERE LM.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE F FROM frame F WHERE F.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE MD FROM matchDetails MD WHERE MD.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE M FROM _match M WHERE M.tournamentID = tournamentID;

-- groups data
    DELETE GS FROM groupStandings GS WHERE GS.tournamentID = tournamentID;    

    DELETE GS FROM groupSeeding GS WHERE GS.tournamentID = tournamentID;    

    DELETE PG FROM playerGroup PG WHERE PG.groupID IN
	(SELECT GT.id FROM groupTournament GT WHERE GT.tournamentID = tournamentID);

    DELETE GT FROM groupTournament GT WHERE GT.tournamentID = tournamentID;


-- general tournament data
    DELETE TP FROM tournamentPoints TP WHERE TP.tournamentID = tournamentID;

    UPDATE tournament T SET T.bracket = NULL, T.status = "Standby" WHERE T.id = tournamentID;
COMMIT;
END;



-- deletes all tournament data
CREATE PROCEDURE deleteTournament(IN tournamentID INT)
BEGIN
START TRANSACTION;
-- match data
    DELETE B FROM break B WHERE B.tournamentID = tournamentID;

    DELETE LM FROM liveMatch LM WHERE LM.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE F FROM frame F WHERE F.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE MD FROM matchDetails MD WHERE MD.matchID IN
	(SELECT M.id FROM _match M WHERE M.tournamentID=tournamentID);

    DELETE M FROM _match M WHERE M.tournamentID = tournamentID;

-- groups data
    DELETE GS FROM groupStandings GS WHERE GS.tournamentID = tournamentID;    

    DELETE GS FROM groupSeeding GS WHERE GS.tournamentID = tournamentID;    

    DELETE PG FROM playerGroup PG WHERE PG.groupID IN
	(SELECT GT.id FROM groupTournament GT WHERE GT.tournamentID = tournamentID);

    DELETE GT FROM groupTournament GT WHERE GT.tournamentID = tournamentID;


-- general tournament data
    DELETE TP FROM tournamentPoints TP WHERE TP.tournamentID = tournamentID;

    DELETE TS FROM tournamentStandings TS WHERE TS.tournamentID = tournamentID;

    DELETE PT FROM playerTournament PT WHERE PT.tournamentID = tournamentID;

    DELETE TD FROM tournament_details TD WHERE TD.tournamentID = tournamentID;

    DELETE T FROM tournament T WHERE T.id = tournamentID;
COMMIT;
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



