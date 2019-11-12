
-- ORGANISATIONS ------------------------------------------------------
INSERT INTO organisation (name)
VALUES("NSFU");
-- --------------------------------------------------------------------


-- LEAGUES ------------------------------------------------------------
INSERT INTO league(name)
VALUES('None');

INSERT INTO league(name, organisationID, billiardID, ageID, sex) VALUES
("NFSU cup", 2, 1, 5, ""),
("Galychyna cup", 2, 1, 1, ""),
("NFSU cup", 2, 2, 1, ""),
("NFSU cup", 2, 2, 3, "Men");
-- --------------------------------------------------------------------


-- CLUBS --------------------------------------------------------------
INSERT INTO club(name, country, city, nrOfTables) VALUES
("Snooker Lviv", "Ukraine", "Lviv", 6),
("Zovex", "Ukraine", "Lviv", 6),
("Bingo", "Ukraine", "Kyiv", 10),
("Danger", "Mesopotamia", "Paraguay", 5),
("Admiral", "Russia", "Moscow", 1);
-- --------------------------------------------------------------------


-- PLAYERS ------------------------------------------------------------
INSERT INTO player(firstName, lastName) VALUES
("zaaaa", "zaaaa"),
("zbbbb", "zbbbb"),
("zcccc", "zcccc"),
("zdddd", "zdddd"),
("zeeee", "zeeee"),
("zffff", "zffff"),
("zgggg", "zgggg"),
("zhhhh", "zhhhh"),
-- 8
("ziiii", "ziiii"),
("zjjjj", "zjjjj"),
("zkkkk", "zkkkk"),
("zllll", "zllll"),
("zmmmm", "zmmmm"),
("znnnn", "znnnn"),
("zoooo", "zoooo"),
("zpppp", "zpppp"),
-- 16
("zqqqq", "zqqqq"),
("zrrrr", "zrrrr"),
("zssss", "zssss"),
("ztttt", "ztttt"),
("zuuuu", "zuuuu"),
("zvvvv", "zvvvv"),
("zwwww", "zwwww"),
("zxxxx", "zxxxx"),
-- 24
("zyyyy", "zyyyy"),
("zzzzz", "zzzzz"),
("zabcd", "zabcd"),
("zefgh", "zefgh"),
("zijkl", "zijkl"),
("zmnop", "zmnop"),
("zqrst", "zqrst"),
("zuvwx", "zuvwx");
-- 32

INSERT INTO player(lastName, firstName) VALUES
("Trigg", "Alan"),
("Semko", "Yuriy"),
("Baidala", "Kyrylo"),
("Delyatynskyy", "Stepan"),
("Petrosov", "Arsen"),
("Ivasiv", "Andriy"),
("Kryvko", "Bogdan"),
("Katruk", "Mykhailo"),
("Voloshynov", "Danylo"),
("Fedevych", "Vitaliy"),
("Kharlov", "Valentyn"),
("Agadganov", "Chingiz"),
("Solomenchuk", "Pavlo"),
("Levytskyi", "Vadym"),
("Samsonov", "Vitaliy"),
("Kaznovskiy", "Bogdan"),
("Sokhan", "Bogdan"),
("Levi", "Valeriy"),
("Polidovych", "Marian"),
("Gusar", "Roman"),
("Solomenchuk", "Petro"),
("Khachatrian", "Mikhael"),
("Stetsyshyn", "Petro"),
("Gudenko", "Mykola");

INSERT INTO player(id, firstName, lastName) VALUES
(-1, "WALK", "OVER"),
(-2, "", "");
-- -------------------------------------------------------------------


-- RATING -----------------------------------------------------------
INSERT INTO rating(leagueID, playerID, points) VALUES
(2, 33, 48),
(2, 34, 44),
(2, 35, 38),
(2, 36, 19),
(2, 37, 18),
(2, 38, 17),
(2, 39, 14),
(2, 40, 12),
(2, 41, 9),
(2, 42, 7),
(2, 43, 6),
(2, 44, 6),
(2, 45, 5),
(2, 46, 5),
(2, 47, 4),
(2, 48, 4),
(2, 49, 3),
(2, 50, 3),
(2, 51, 3),
(2, 52, 2),
(2, 53, 2),
(2, 54, 1),
(2, 55, 1),
(2, 56, 1);
-- ------------------------------------------------------------------


-- USERS -------------------------------------------------------------
INSERT INTO _user(login, hash, email, userType) VALUES
("admin", "$2y$10$E.aTBwM/JvVd62Uz7uwlMeNkcLxk3dQxuSjjSDj77MXilPeMozJNS", "levko@gmail.com", "admin");

INSERT INTO _user(login, hash, email, userType) VALUES
("markoni", "$2y$10$.nPCymKfMAs04E0H36m6demzI5UO3HNPWD4jS7WLPfWgi/OUsOSOi", "delevkoo@gmail.com", "regular");



-- TOURNAMENTS -------------------------------------------------------
INSERT INTO tournament(name, leagueID) VALUES
("NFSU etap 1", 2),
("NFSU etap 2", 2),
("NFSU etap 3", 2),
("NFSU etap 4", 2);

INSERT INTO tournament(name) VALUES
("Qualification for finals");

INSERT INTO tournament(name)
VALUES("Lviv cup");

-- INSERT INTO tournament(name, startDate, endDate) VALUES
-- ("Test CUP 1", "2019-02-19 00:30:00", "2019-02-19 01:00:00"),
-- ("Test CUP 2", "2019-02-19 10:00:00", "2019-02-20 23:00:00"),
-- ("Test CUP 3", "2019-02-19 10:00:00", "2019-02-19 21:00:00"),
-- ("Test CUP 4", "2019-02-18 21:25:00", "2019-02-19 10:00:00"),
-- ("Test CUP 5", "2019-02-19 21:25:00", "2019-02-19 21:26:00"),
-- ("Test CUP 6", "2019-02-18 21:25:00", "2019-02-18 21:26:00");
-- ------------------------------------------------------------------


-- PLAYER TOURNAMENT ------------------------------------------------
INSERT INTO playerTournament(tournamentID, playerID)
VALUES
(1,33), 
(1,34),
(1,35), 
(1,36), 
(1,37), 
(1,38),
(1,39),
(1,40),
(1,41),
(1,42),
(1,43),
(1,44),
(1,45),
(1,46),
(1,47),
(1,48),
(1,49),
(1,50),
(1,51),
(1,52);

INSERT INTO playerTournament(tournamentID, playerID)
VALUES
(2,33), 
(2,34),
(2,35), 
(2,36), 
(2,37), 
(2,38),
(2,39),
(2,40),
(2,41),
(2,42),
(2,43),
(2,44),
(2,45),
(2,46),
(2,47);

INSERT INTO playerTournament(tournamentID, playerID)
VALUES(5,41), (5,47), (5,40);

INSERT INTO playerTournament(tournamentID, playerID)
VALUES(3,41), (3,33), (3,36), (3,39);

INSERT INTO playerTournament(tournamentID, playerID)
VALUES(4,51), (4,33), (4,34), (4,35), (4,36);
-- ------------------------------------------------------------------


-- TOURNAMENT STANDINGS ---------------------------------------------
-- INSERT INTO tournamentStandings(tournamentID, playerID, place, points)
-- VALUES
-- (1,1,1,1),
-- (1,2,2,2), 
-- (1,3,3,3), 
-- (1,4,4,4),
-- (1,5,5,5), 
-- (1,6,6,6), 
-- (1,7,7,7), 
-- (1,8,8,8), 
-- (1,9,9,9), 
-- (1,10,10,10), 
-- (1,11,11,11), 
-- (1,12,12,12),
-- (1,13,13,13),
-- (1,14,14,14),
-- (1,15,15,15),
-- (1,16,16,16),
-- (1,17,17,17);
-- 
-- INSERT INTO tournamentStandings(tournamentID, playerID, place, points)
-- VALUES
-- (2,1,1,1), 
-- (2,2,2,2), 
-- (2,3,3,3), 
-- (2,4,4,4),
-- (2,5,5,5), 
-- (2,6,6,6), 
-- (2,7,7,7), 
-- (2,8,8,8), 
-- (2,9,9,9), 
-- (2,10,10,10), 
-- (2,11,11,11), 
-- (2,12,12,12),
-- (2,13,13,13),
-- (2,14,14,14),
-- (2,15,15,15),
-- (2,16,16,16),
-- (2,17,17,17);
-- 
-- INSERT INTO tournamentStandings(tournamentID, playerID, place, points)
-- VALUES(5,1,3,1.25), (5,7,2,2.5), (5,10,1,3.75);

-- INSERT INTO tournamentStandings(tournamentID, playerID, place, points)
-- VALUES(3,1,4,1.25), (3,3,3,2.5), (3,6,1,5), (3,9,2,3.75);

-- INSERT INTO tournamentStandings(tournamentID, playerID, place, points)
-- VALUES(4,1,1,6.75), (4,3,4,2.5), (4,4,3,3.75), (4,5,2,5), (4,6,5,1.25);
-- ------------------------------------------------------------------


-- TOURNAMENT POINTS ------------------------------------------------
-- INSERT INTO tournamentPoints(tournamentID, lostInRoundNo, lostInRoundType, points)
-- VALUES
-- (4, 1, "K/O", 5),
-- (4, 2, "K/O", 10),
-- (4, 3, "K/O", 20),
-- (4, 4, "K/O", 45); -- for up to 8 players, K/O
-- 
-- INSERT INTO tournamentPoints(tournamentID, lostInRoundNo, lostInRoundType, points)
-- VALUES
-- (3, 1, "LOW", 1),
-- (3, 2, "LOW", 3.5),
-- (3, 1, "K/O", 10),
-- (3, 2, "K/O", 25); -- for up to 4 players, D/E
-- ------------------------------------------------------------------


-- RATING -----------------------------------------------------------
-- INSERT INTO rating(leagueID, playerID, points) VALUES
-- (2,1,0), 
-- (2,2,0), 
-- (2,3,0), 
-- (2,4,0),
-- (2,5,0), 
-- (2,6,0), 
-- (2,7,0), 
-- (2,8,0), 
-- (2,9,0), 
-- (2,10,0), 
-- (2,11,0), 
-- (2,12,0),
-- (2,13,0),
-- (2,14,0),
-- (2,15,0),
-- (2,16,0),
-- (2,17,0);
-- 

-- ------------------------------------------------------------------

-- UPDATE tournament SET status="Finished" WHERE id=1;
-- UPDATE tournament SET status="Finished" WHERE id=2;

