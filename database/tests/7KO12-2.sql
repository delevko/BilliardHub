-- K/O

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=1 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=1 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=2 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=2 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=3 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=3 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=4 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=4 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=5 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=5 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=6 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=6 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=7 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=7 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=8 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=8 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=9 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=9 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=10 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=10 AND M.roundType="K/O");

UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=7 AND M.counter=11 AND M.roundType="K/O";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=7 AND M.counter=11 AND M.roundType="K/O");

