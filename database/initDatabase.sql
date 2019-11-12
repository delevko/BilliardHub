
DROP TABLE IF EXISTS break CASCADE;
DROP TABLE IF EXISTS frame CASCADE;
DROP TABLE IF EXISTS matchDetails;
DROP TABLE IF EXISTS liveMatch;
DROP TABLE IF EXISTS _match CASCADE;
DROP TABLE IF EXISTS _table CASCADE;

DROP TABLE IF EXISTS tournamentStandings;
DROP TABLE IF EXISTS groupStandings;
DROP TABLE IF EXISTS tournamentPoints;
DROP TABLE IF EXISTS rating;

DROP TABLE IF EXISTS playerTournament CASCADE;
DROP TABLE IF EXISTS playerGroup CASCADE;
DROP TABLE IF EXISTS groupTournament CASCADE;
DROP TABLE IF EXISTS groupSeeding CASCADE;
DROP TABLE IF EXISTS player CASCADE;
DROP TABLE IF EXISTS _user CASCADE;
DROP TABLE IF EXISTS tournament CASCADE;

DROP TABLE IF EXISTS league CASCADE;
DROP TABLE IF EXISTS organisation CASCADE;

DROP TABLE IF EXISTS billiard CASCADE;
DROP TABLE IF EXISTS club CASCADE;
DROP TABLE IF EXISTS age CASCADE;
-- DROP TABLE IF EXISTS sex CASCADE;
DROP TABLE IF EXISTS bracket CASCADE;

DROP FUNCTION IF EXISTS getVal;

DROP TRIGGER IF EXISTS tablesInit;
DROP TRIGGER IF EXISTS playersIncrement;
DROP TRIGGER IF EXISTS playersInAGroupIncrement;


-- FOR VIEW parametrisation
CREATE FUNCTION getVal() 
RETURNS INTEGER DETERMINISTIC NO SQL 
return @getVal;


-- BILLIARD TYPE ------------------------------------------------------
CREATE TABLE billiard(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL UNIQUE,

	PRIMARY KEY(id)
);
-- --------------------------------------------------------------------



-- BRACKET ------------------------------------------------------------
CREATE TABLE bracket(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL UNIQUE,

	PRIMARY KEY(id)
);
-- --------------------------------------------------------------------



-- AGE ----------------------------------------------------------------
CREATE TABLE age(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL UNIQUE,

	PRIMARY KEY(id)
);
-- --------------------------------------------------------------------



-- SEX ----------------------------------------------------------------
-- CREATE TABLE sex(
--	id INT NOT NULL AUTO_INCREMENT,
--	name VARCHAR(50) NOT NULL UNIQUE,
--	PRIMARY KEY(id)
-- );
-- --------------------------------------------------------------------



-- ORGANISATION -------------------------------------------------------
CREATE TABLE organisation(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL UNIQUE,

	PRIMARY KEY(id)
);
-- --------------------------------------------------------------------



-- LEAGUE -------------------------------------------------------------
CREATE TABLE league(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,

	organisationID INT NOT NULL DEFAULT 1,
	billiardID INT NOT NULL DEFAULT 1,
	ageID INT NOT NULL DEFAULT 1,
	sex VARCHAR(20) NOT NULL DEFAULT "",
--	sexID VARCHAR(20) NOT NULL DEFAULT 1,

	PRIMARY KEY (id),
	FOREIGN KEY (organisationID) REFERENCES organisation(id),
	FOREIGN KEY (billiardID) REFERENCES billiard(id),
	FOREIGN KEY (ageID) REFERENCES age(id),
--	FOREIGN KEY (sexID) REFERENCES sex(id),
	UNIQUE KEY(name, organisationID, billiardID, ageID, sex)
);
-- --------------------------------------------------------------------



-- CLUB ---------------------------------------------------------------
CREATE TABLE club(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	city VARCHAR(30) NOT NULL,
	country VARCHAR(30) NOT NULL,
	nrOfTables int NOT NULL DEFAULT 0,
	photo VARCHAR(50) NOT NULL DEFAULT "default.png",

	PRIMARY KEY(id)
);
-- --------------------------------------------------------------------



-- PLAYER -------------------------------------------------------------
CREATE TABLE player(
	id INT NOT NULL AUTO_INCREMENT,
	firstName VARCHAR(20) NOT NULL,
	lastName VARCHAR(30) NOT NULL,	
	photo VARCHAR(50) NOT NULL DEFAULT "default.png",
	
	birthday DATE,
	country VARCHAR(30),
	city VARCHAR(50),
	sex VARCHAR(20),

	highestBreak INT NOT NULL DEFAULT 0,
	
	PRIMARY KEY(id),
	UNIQUE KEY(firstName, lastName)
);
-- --------------------------------------------------------------------



-- USER ---------------------------------------------------------------
CREATE TABLE _user(
	id INT NOT NULL AUTO_INCREMENT,
	
	login VARCHAR(20) NOT NULL,
	hash VARCHAR(256) NOT NULL,
	email VARCHAR(30),
	userType VARCHAR(20),
	
	dateOfRegistration DATE,
	
	PRIMARY KEY(id),
	UNIQUE KEY(login)
);
-- --------------------------------------------------------------------



-- TOURNAMENT ---------------------------------------------------------
CREATE TABLE tournament(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	status VARCHAR(20) NOT NULL DEFAULT "Announced",
	bracket VARCHAR(100),
	seeding VARCHAR(20) NOT NULL DEFAULT "Standart",
	
	registeredPlayers INT NOT NULL DEFAULT 0,
	groupPlayers INT NOT NULL DEFAULT 0,
	totalPlayers INT NOT NULL DEFAULT 0,
	seededPlayers INT NOT NULL DEFAULT 0,

	UP_Rounds INT NOT NULL DEFAULT 0,
	LOW_Rounds INT NOT NULL DEFAULT 0,
	KO_Rounds INT NOT NULL DEFAULT 0,
	seeded_Round INT NOT NULL DEFAULT 1,
	additional_Rounds INT NOT NULL DEFAULT 0,

	UP_Total INT NOT NULL DEFAULT 0,
	LOW_Total INT NOT NULL DEFAULT 0,
	KO_Total INT NOT NULL DEFAULT 0,

	KO_Matches INT, -- for DE

	groupMin INT NOT NULL DEFAULT 0,
	groupProceed INT NOT NULL DEFAULT 0,
	totalGroupProceed INT NOT NULL DEFAULT 0,
	nrOfGroups INT NOT NULL DEFAULT 0,
	Group_Rounds INT NOT NULL DEFAULT 0,

	groupDone INT NOT NULL DEFAULT FALSE,

	startDate DATETIME,
	endDate DATETIME,

	leagueID INT NOT NULL DEFAULT 1,
	clubID INT NOT NULL DEFAULT 1,
	minBreak INT NOT NULL DEFAULT 20,

	PRIMARY KEY(id),
	FOREIGN KEY(leagueID) REFERENCES league(id),
	FOREIGN KEY(clubID) REFERENCES club(id),
	UNIQUE KEY(name, leagueID)
);
-- --------------------------------------------------------------------



-- PLAYER-TOURNAMENT --------------------------------------------------
CREATE TABLE playerTournament(
	id INT NOT NULL AUTO_INCREMENT,	

	seed INT,
	playerID INT NOT NULL,
	tournamentID INT NOT NULL,
	
	PRIMARY KEY(id),
	FOREIGN KEY(playerID) REFERENCES player(id),
	FOREIGN KEY(tournamentID) REFERENCES tournament(id),
	UNIQUE KEY(playerID, tournamentID)
);

-- TRIGGER to increment players in a tournament
delimiter $$
CREATE TRIGGER playersIncrement BEFORE INSERT ON playerTournament
FOR EACH ROW
BEGIN
	UPDATE tournament SET registeredPlayers=registeredPlayers+1
	WHERE id = NEW.tournamentID;
END;
$$
delimiter ;
-- --------------------------------------------------------------------



-- GROUP-TOURNAMENT ---------------------------------------------------
CREATE TABLE groupTournament(
	id INT NOT NULL AUTO_INCREMENT,	

	groupNum INT NOT NULL,
	tournamentID INT NOT NULL,
	nrOfPlayers INT NOT NULL DEFAULT 0,
	
	PRIMARY KEY(id),
	FOREIGN KEY(tournamentID) REFERENCES tournament(id),
	UNIQUE KEY(groupNum, tournamentID)
);
-- --------------------------------------------------------------------



-- GROUP-SEEDING ------------------------------------------------------
CREATE TABLE groupSeeding(
	id INT NOT NULL AUTO_INCREMENT,	

	seed INT,
	playerID INT NOT NULL,
	tournamentID INT NOT NULL,
	
	PRIMARY KEY(id),
	FOREIGN KEY(playerID) REFERENCES player(id),
	FOREIGN KEY(tournamentID) REFERENCES tournament(id),
	UNIQUE KEY(playerID, tournamentID)
);
-- --------------------------------------------------------------------



-- PLAYER-GROUP -------------------------------------------------------
CREATE TABLE playerGroup(
	id INT NOT NULL AUTO_INCREMENT,	

	groupID INT NOT NULL,
	playerID INT NOT NULL,
	playerNum INT NOT NULL,
	points DECIMAL(8,2) NOT NULL DEFAULT 0,
	mWon INT NOT NULL DEFAULT 0,
	mLost INT NOT NULL DEFAULT 0,
	fWon INT NOT NULL DEFAULT 0,
	fLost INT NOT NULL DEFAULT 0,
	
	PRIMARY KEY(id),
	FOREIGN KEY(playerID) REFERENCES player(id),
	FOREIGN KEY(groupID) REFERENCES groupTournament(id),
	UNIQUE KEY(groupID, playerNum),
	UNIQUE KEY(groupID, playerID)
);
-- --------------------------------------------------------------------

-- TRIGGER to increment players in a group
delimiter $$
CREATE TRIGGER playersInAGroupIncrement BEFORE INSERT ON playerGroup
FOR EACH ROW
BEGIN
	UPDATE groupTournament SET nrOfPlayers=nrOfPlayers+1
	WHERE id = NEW.groupID;
END;
$$
delimiter ;
-- --------------------------------------------------------------------



-- SNOOKER TABLE ------------------------------------------------------
CREATE TABLE _table(
	id INT NOT NULL AUTO_INCREMENT,

	_number INT NOT NULL,
	clubID INT NOT NULL,

	matchID INT,
	
	status VARCHAR(20) NOT NULL DEFAULT "Available",
	PRIMARY KEY(id),
	FOREIGN KEY(clubID) REFERENCES club(id),
-- FOREIGN KEY(matchID) REFERENCES _match(id),
	UNIQUE KEY(_number, clubID)
);
-- --------------------------------------------------------------------

-- TRIGGER to insert club tables into _table
delimiter $$
CREATE TRIGGER tablesInit AFTER INSERT ON club
FOR EACH ROW
BEGIN
	DECLARE i INT DEFAULT 1;
	WHILE i <= NEW.nrOfTables DO
		INSERT INTO _table (_number, clubID)
		VALUES(i, NEW.id);
		SET i = i+1;
	END WHILE;
END;
$$
delimiter ;



-- MATCH --------------------------------------------------------------
CREATE TABLE _match(
	id INT NOT NULL AUTO_INCREMENT,
	counter INT NOT NULL,
	tournamentID INT NOT NULL,

	player1ID INT NOT NULL DEFAULT -2,-- empty
	player2ID INT NOT NULL DEFAULT -2,-- empty
	player1Score INT,
	player2Score INT,
	

	bestOF INT NOT NULL DEFAULT 3,
	roundNo INT NOT NULL,
	roundType VARCHAR(20) NOT NULL,
	groupID INT,

	winnerMatchID INT NOT NULL DEFAULT 0,
	winnerMatchCounter INT NOT NULL DEFAULT 0,
	loserMatchID INT NOT NULL DEFAULT 0,
	loserMatchCounter INT NOT NULL DEFAULT 0,
	loserPlaces VARCHAR(20),

	youtube VARCHAR(200),

	tableID INT,

	PRIMARY KEY(id),
	FOREIGN KEY(player1ID) REFERENCES player(id),
	FOREIGN KEY(player2ID) REFERENCES player(id),
	FOREIGN KEY(tournamentID) REFERENCES tournament(id),
	FOREIGN KEY(tableID) REFERENCES _table(id),
	FOREIGN KEY(groupID) REFERENCES groupTournament(id),
	
	UNIQUE KEY(tournamentID, counter, roundType)
);
-- --------------------------------------------------------------------

-- LIVE MATCH ---------------------------------------------------------
CREATE TABLE liveMatch(
	id INT NOT NULL AUTO_INCREMENT,

	matchID INT NOT NULL,
	frameCounter INT NOT NULL,
	
	points1 INT,
	points2 INT,
	break1 INT,
	break2 INT,

	PRIMARY KEY(id),
	FOREIGN KEY(matchID) REFERENCES _match(id),
	UNIQUE(matchID, frameCounter)
);
-- -------------------

-- MATCH DETAILS ------------------------------------------------------
CREATE TABLE matchDetails(
    id INT NOT NULL AUTO_INCREMENT,
	matchID INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT "Announced",

    PRIMARY KEY(id),
	FOREIGN KEY(matchID) REFERENCES _match(id),
	UNIQUE KEY(matchID)
);
-- --------------------------------------------------------------------



-- FRAME --------------------------------------------------------------
CREATE TABLE frame (
	id INT NOT NULL AUTO_INCREMENT,
	matchID INT NOT NULL,
    counter INT NOT NULL,

	points1 INT NOT NULL DEFAULT 0,
	points2 INT NOT NULL DEFAULT 0,

	PRIMARY KEY(id),
	FOREIGN KEY(matchID) REFERENCES _match(id),
	UNIQUE(matchID, counter)
);
-- --------------------------------------------------------------------



-- BREAK --------------------------------------------------------------
CREATE TABLE break (
	id INT NOT NULL AUTO_INCREMENT,
	
	XorY BOOLEAN NOT NULL,
	points INT NOT NULL,
	frameCounter INT NOT NULL,
	
	playerID INT NOT NULL,
	opponentID INT NOT NULL,
	matchID INT NOT NULL,
	tournamentID INT,
	
-- clubID INT to store club's best breaks	

	PRIMARY KEY(id),
	FOREIGN KEY(playerID) REFERENCES player(id),
	FOREIGN KEY(matchID) REFERENCES _match(id),
	FOREIGN KEY(tournamentID) REFERENCES tournament(id)
);
-- --------------------------------------------------------------------



-- TOURNAMENT POINTS -----------------------------------------------
CREATE TABLE tournamentPoints(
    id INT NOT NULL AUTO_INCREMENT,
    tournamentID INT NOT NULL,

    lostInRoundNo INT NOT NULL,
    lostInRoundType VARCHAR(20) NOT NULL,
    points DECIMAL(8,2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(tournamentID) REFERENCES tournament(id),
    UNIQUE KEY(tournamentID, lostInRoundNo, lostInRoundType)
);
-- -----------------------------------------------------------------



-- GROUP STANDINGS -------------------------------------------------
CREATE TABLE groupStandings(
    id INT NOT NULL AUTO_INCREMENT,

    tournamentID INT NOT NULL,
    playerID INT NOT NULL,
    groupPlace INT NOT NULL,
	groupNum INT NOT NULL,
    points DECIMAL(8,2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(tournamentID) REFERENCES tournament(id),
    FOREIGN KEY(playerID) REFERENCES player(id),
    UNIQUE KEY(tournamentID, playerID),
    UNIQUE KEY(tournamentID, groupNum, groupPlace)
);
-- -----------------------------------------------------------------



-- TOURNAMENT STANDINGS --------------------------------------------
CREATE TABLE tournamentStandings(
    id INT NOT NULL AUTO_INCREMENT,

    tournamentID INT NOT NULL,
    playerID INT NOT NULL,
    place VARCHAR(20) NOT NULL,
    points DECIMAL(8,2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(tournamentID) REFERENCES tournament(id),
    FOREIGN KEY(playerID) REFERENCES player(id),
    UNIQUE KEY(tournamentID, playerID)
);
-- -----------------------------------------------------------------



-- RATING ----------------------------------------------------------
CREATE TABLE rating(
    id INT NOT NULL AUTO_INCREMENT,
    leagueID INT NOT NULL,
    playerID INT NOT NULL,
    points DECIMAL(8,2) NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(leagueID) REFERENCES league(id),
    FOREIGN KEY(playerID) REFERENCES player(id),
    UNIQUE KEY(leagueID, playerID)
);
-- -----------------------------------------------------------------

