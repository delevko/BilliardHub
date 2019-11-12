-- UP 1
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=1 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=1 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=2 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=2 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=3 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=3 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=4 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=4 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=5 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=5 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=6 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=6 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=7 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=7 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=8 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=8 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=9 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=9 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=10 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=10 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=11 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=11 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=12 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=12 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=13 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=13 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=14 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=14 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=15 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=15 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=16 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=16 AND M.roundType="UP");

-- UP 2
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=17 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=17 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=18 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=18 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=19 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=19 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=20 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=20 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=21 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=21 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=22 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=22 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=23 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=23 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=24 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=24 AND M.roundType="UP");


-- LOW 1
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=25 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=25 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=26 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=26 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=27 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=27 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=28 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=28 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=29 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=29 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=30 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=30 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=31 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=31 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=32 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=32 AND M.roundType="LOW");

-- LOW 2
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=33 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=33 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=34 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=34 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=35 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=35 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=36 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=36 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=37 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=37 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=38 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=38 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=39 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=39 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=40 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=40 AND M.roundType="LOW");


-- K/O 1
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=41 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=41 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=42 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=42 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=43 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=43 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=44 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=44 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=45 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=45 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=46 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=46 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=47 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=47 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=48 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=48 AND M.roundType="K/O");

-- K/O 2
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=49 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=49 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=50 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=50 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=51 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=51 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=52 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=52 AND M.roundType="K/O");

-- K/O 3
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=53 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=53 AND M.roundType="K/O");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=54 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=54 AND M.roundType="K/O");

-- K/O 4
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=2 AND M.counter=55 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=2 AND M.counter=55 AND M.roundType="K/O");

