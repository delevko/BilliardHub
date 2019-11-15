-- UP 1
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=1 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=1 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=2 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=2 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=3 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=3 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=4 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=4 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=5 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=5 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=6 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=6 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=7 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=7 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=8 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=8 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=9 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=9 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=10 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=10 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=11 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=11 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=12 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=12 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=13 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=13 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=14 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=14 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=15 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=15 AND M.roundType="UP");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=16 AND M.roundType="UP";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=16 AND M.roundType="UP");


-- LOW 1
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=29 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=29 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=30 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=30 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=31 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=31 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=32 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=32 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=33 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=33 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=34 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=34 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=35 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=35 AND M.roundType="LOW");
UPDATE _match M SET M.player1Score=2, M.player2Score=1 WHERE M.tournamentID=9 AND M.counter=36 AND M.roundType="LOW";
UPDATE matchDetails MD SET MD.status="Finished" WHERE MD.matchID=(SELECT M.id FROM _match M WHERE M.tournamentID=9 AND M.counter=36 AND M.roundType="LOW");

