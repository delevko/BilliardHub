<?php

require("../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$tableID = $_GET["id"];

	if( exists("_table", $tableID) )
	{
		lobbyGenerate($tableID);
	}
	else
	{
		redirect(PATH_H);
	}
}
else
{
	redirect(PATH_H);
}


function lobbyGenerate($tableID)
{
	$query = "SELECT
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player1Score, M.player2Score, M.bestOf,
    LM.points1, LM.points2, LM.break1, LM.break2,
    T.name AS tournamentName, C.name AS clubName, tbl._number
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN tournament T ON M.tournamentID = T.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    LEFT JOIN liveMatch LM ON LM.matchID = tbl.matchID
    JOIN club C ON tbl.clubID = C.id
WHERE tbl.id = ?";

	$data = query($query, $tableID);

	$player1 = $data[0][0]; $player2 = $data[0][1];
	$frames1 = $data[0][2]; $frames2 = $data[0][3];
	$bestOf = $data[0][4];

	$points1 = $data[0][5]; $points2 = $data[0][6];
	$break1 = $data[0][7]; $break2 = $data[0][8];

	$clubName = $data[0][10]; $tableNum = $data[0][11];

	
	$highlight1 = ""; $highlight2 = "";
	nonEmpty($break1) ? $highlight1.=" highlight" : $highlight2.=" highlight";


	require("plashka.html");
}
?>
