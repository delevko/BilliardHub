
-- SAME ORDER

DROP VIEW IF EXISTS matchView;
DROP VIEW IF EXISTS generalGroupView;
DROP VIEW IF EXISTS playerGroupView;
DROP VIEW IF EXISTS groupMatchesView;
DROP VIEW IF EXISTS groupStandingsView;

DROP VIEW IF EXISTS tableView;
DROP VIEW IF EXISTS ranking;

DROP VIEW IF EXISTS generalTournamentView;
DROP VIEW IF EXISTS matchesTournamentView;
DROP VIEW IF EXISTS playerTournamentView;
DROP VIEW IF EXISTS standingsTournamentView;

DROP VIEW IF EXISTS leagueView;
DROP VIEW IF EXISTS remainingPlayersForTournament;
DROP VIEW IF EXISTS playersOutsideOfLeague;

DROP VIEW IF EXISTS breakView;

-- MATCH VIEW ---------------------------------------------------------
CREATE VIEW matchView AS
SELECT
    M.id AS matchID, M.counter, M.player1ID, M.player2ID,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1, X.photo AS photo1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2, Y.photo AS photo2,
    M.player1Score, M.player2Score,
    M.bestOf, M.winnerMatchID, M.loserMatchID, M.loserPlaces,
    M.youtube, MD.status, tbl._number,
    T.clubID, C.name AS clubName,
    T.id AS tournamentID, T.name AS tournamentName,
    M.roundNo, M.roundType,
    GT.id AS groupID, GT.groupNum
FROM _match M
    JOIN player AS X ON player1ID = X.id
    JOIN player AS Y ON player2ID = Y.id
    JOIN tournament T ON M.tournamentID = T.id
    JOIN club C ON T.clubID = C.id
    JOIN matchDetails MD ON MD.matchID = M.id
    LEFT JOIN _table tbl ON M.tableID = tbl.id
    LEFT JOIN groupTournament GT ON M.groupID = GT.id;
-- --------------------------------------------------------------------



-- GENERAL GROUP VIEW -------------------------------------------------
CREATE VIEW generalGroupView AS
SELECT
    GT.id AS groupID, GT.groupNum AS groupNum,
    GT.nrOfPlayers AS nrOfPlayers,
    T.id AS tournamentID, T.name AS tournamentName
FROM groupTournament AS GT
    JOIN tournament AS T
        ON GT.tournamentID = T.id;
-- --------------------------------------------------------------------



-- PLAYER GROUP VIEW --------------------------------------------------
CREATE VIEW playerGroupView AS
SELECT
    GT.id AS groupID, GT.groupNum AS groupNum, 
    GT.nrOfPlayers AS nrOfPlayers,
    PG.playerNum AS playerNum, PG.playerID AS playerID,
    CONCAT(P.firstName, ' ', P.lastName) AS playerName,
	P.photo AS playerPhoto,
    GS.seed AS playerSeed, PG.mWon, PG.mLost, PG.fWon, PG.fLost,
    T.id AS tournamentID, T.name AS tournamentName
FROM groupTournament AS GT
    LEFT JOIN playerGroup AS PG
        ON GT.id = PG.groupID
    LEFT JOIN player AS P
        ON PG.playerID = P.id
    JOIN tournament AS T
        ON GT.tournamentID = T.id
    LEFT JOIN groupSeeding GS
        ON GS.playerID = P.id AND GS.tournamentID = T.id;
-- --------------------------------------------------------------------



-- GROUP MATCHES VIEW -------------------------------------------------
CREATE VIEW groupMatchesView AS
SELECT
    M.id AS matchID, MD.status, M.youtube, 
    M.player1Score, M.player2Score,
    PG1.playerNum AS player1Num, M.player1ID,
    PG2.playerNum AS player2Num, M.player2ID,
    M.tournamentID, GT.id AS groupID, GT.groupNum
FROM _match M
    JOIN playerGroup PG1 ON M.player1ID = PG1.playerID
        AND M.groupID = PG1.groupID
    JOIN playerGroup PG2 ON M.player2ID = PG2.playerID
        AND M.groupID = PG2.groupID
    JOIN groupTournament GT ON M.groupID = GT.id
        AND GT.tournamentID = M.tournamentID
    JOIN matchDetails MD ON M.id = MD.matchID;
-- --------------------------------------------------------------------



-- GROUP STANDINGS VIEW -----------------------------------------------
CREATE VIEW groupStandingsView AS
SELECT
    GS.playerID AS playerID, P.photo AS photo,
	CONCAT(P.lastName, ' ', P.firstName) AS player,
    GS.points, GS.groupPlace, GS.groupNum, GS.tournamentID, gs.seed
FROM groupStandings GS 
    JOIN player P ON GS.playerID = P.id
	JOIN groupSeeding gs ON GS.tournamentID = gs.tournamentID
		AND GS.playerID = gs.playerID;
-- --------------------------------------------------------------------



-- TABLE VIEW ---------------------------------------------------------
CREATE VIEW tableView AS
SELECT
    tbl.id AS tableID, tbl._number, tbl.clubID, C.name AS clubName,
	C.photo AS clubPhoto,
    tbl.status AS tableStatus, MD.status AS matchStatus,
    M.counter AS matchCounter, tbl.matchID,
	M.player1ID, M.player2ID, X.photo AS photo1, Y.photo AS photo2,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player1Score, M.player2Score, M.bestOf, M.youtube,
    M.tournamentID, T.name AS tournamentName,
	LM.points1, LM.points2, LM.break1, LM.break2,
	M.roundNo, M.roundType, M.groupID
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN tournament T ON M.tournamentID = T.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    LEFT JOIN matchDetails MD ON MD.matchID = tbl.matchID
	LEFT JOIN liveMatch LM ON LM.matchID = tbl.matchID
    JOIN club C ON tbl.clubID = C.id;
-- --------------------------------------------------------------------



-- RANKING VIEW -------------------------------------------------------
CREATE VIEW ranking AS
    SELECT CONCAT(P.firstName, ' ', P.lastName) AS player,
    P.photo, R.playerID, R.points, leagueID
    FROM player P
    INNER JOIN rating R ON P.id = R.playerID;
-- --------------------------------------------------------------------



-- GENERAL TOURNAMENT VIEW --------------------------------------------
CREATE VIEW generalTournamentView AS
SELECT
    T.id AS tournamentID, T.name AS tournament, T.status AS status,
    B.name AS billiard, A.name AS age, L.sex AS sex, L.name AS league,
	T.bracket AS bracket, C.id AS clubID, C.name AS clubName,
	T.startDate, T.endDate, C.city, C.country
FROM tournament T
    JOIN league L ON T.leagueID=L.id
    JOIN age A ON L.ageID = A.id
    JOIN billiard B ON L.billiardID = B.id
    JOIN club C ON T.clubID = C.id;
-- --------------------------------------------------------------------


-- MATCHES TOURNAMENT VIEW --------------------------------------------
CREATE VIEW matchesTournamentView AS
SELECT
    M.id AS matchID, M.counter, MD.status, M.youtube, 
    CONCAT(X.firstName, ' ', X.lastName) AS player1Name, M.player1ID,
    CONCAT(Y.firstName, ' ', Y.lastName) AS player2Name, M.player2ID,
	X.photo AS photo1, Y.photo AS photo2,
	SX.seed AS player1Seed, SY.seed AS player2Seed,
    M.player1Score, M.player2Score, M.bestOF,
    M.winnerMatchID, M.winnerMatchCounter,
    M.loserPlaces, M.loserMatchID, M.loserMatchCounter,
    M.roundNo, M.roundType, M.tournamentID,
    GT.id AS groupID, GT.groupNum,
	LM.points1, LM.points2, LM.break1, LM.break2
FROM _match M
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
	LEFT JOIN playerTournament SX ON X.id = SX.playerID
		AND M.tournamentID = SX.tournamentID
	LEFT JOIN playerTournament SY ON Y.id = SY.playerID
		AND M.tournamentID = SY.tournamentID
    JOIN matchDetails MD ON M.id = MD.matchID
    LEFT JOIN groupTournament GT ON M.groupID = GT.id
	LEFT JOIN liveMatch LM ON LM.matchID = M.id;
-- --------------------------------------------------------------------



-- PLAYER TOURNAMENT VIEW ---------------------------------------------
CREATE VIEW playerTournamentView AS
SELECT
    PT.playerID AS playerID, CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    P.photo AS photo, PT.seed, PT.tournamentID, P.birthday AS birthday,
	T.name AS tournamentName, C.name AS clubName, TS.place, TS.points,
	T.startDate, T.endDate, P.country AS playerCountry, P.city AS playerCity
FROM playerTournament PT 
    JOIN player P ON PT.playerID=P.id
	JOIN tournament T ON PT.tournamentID=T.id
	JOIN club C ON T.clubID=C.id
	LEFT JOIN tournamentStandings TS ON P.id = TS.playerID
							AND T.id = TS.tournamentID;
-- --------------------------------------------------------------------



-- STANDINGS TOURNAMENT VIEW ------------------------------------------
CREATE VIEW standingsTournamentView AS
SELECT
    PT.playerID AS playerID, P.photo AS photo,
	CONCAT(P.lastName, ' ', P.firstName) AS player,
    PT.seed, TS.place, TS.points, PT.tournamentID
FROM playerTournament PT 
    JOIN player P ON PT.playerID=P.id
    JOIN tournamentStandings TS ON PT.tournamentID=TS.tournamentID
                                AND PT.playerID=TS.playerID;
-- --------------------------------------------------------------------



-- LEAGUE VIEW --------------------------------------------------------
CREATE VIEW leagueView AS
SELECT
    L.id AS leagueID, L.name AS league, B.name AS billiard, A.name AS age,
    L.sex AS sex, count(T.id) AS tournaments
FROM league L
    LEFT JOIN tournament T ON T.leagueID = L.id
    JOIN age A ON L.ageID = A.id
    JOIN billiard B ON L.billiardID = B.id
GROUP BY L.id;
-- --------------------------------------------------------------------


-- REMAINING PLAYERS FOR TOURNAMENT -----------------------------------
-- (helpful during registration)
CREATE VIEW remainingPlayersForTournament AS
SELECT
    P.id, CONCAT(P.lastName, ' ', P.firstName) AS playerName
FROM player P
WHERE P.id NOT IN (-1,-2)
AND P.id NOT IN
    (SELECT PT.playerID FROM playerTournament PT WHERE tournamentID=getVal());
-- --------------------------------------------------------------------


-- HELPERS FOR PROCEDURES ---------------------------------------------
CREATE VIEW playersOutsideOfLeague AS
SELECT T.leagueID, PT.playerID
    FROM playerTournament PT INNER JOIN tournament T ON PT.tournamentID=T.id
    WHERE NOT EXISTS(SELECT 1 from rating R WHERE R.playerID=PT.playerID AND R.leagueID=T.leagueID)
    AND PT.tournamentID=getVal();
-- --------------------------------------------------------------------


-- BREAK VIEW ---------------------------------------------------------
CREATE VIEW breakView AS
SELECT 
	B.points, B.matchID, B.frameCounter, B.xORy,
	B.tournamentID, T.name AS tournamentName,
	M.roundType, M.roundNo,
	B.playerID, CONCAT(P.lastName, ' ', P.firstName) AS playerName,
	P.photo AS playerPhoto, O.photo AS opponentPhoto,
	B.opponentID, CONCAT(O.lastName, ' ', O.firstName) AS opponentName
FROM break B 
	JOIN player P ON B.playerID = P.id
	JOIN player O ON B.opponentID = O.id
	JOIN _match M ON B.matchID = M.id
	JOIN tournament T ON B.tournamentID = T.id;
-- --------------------------------------------------------------------
