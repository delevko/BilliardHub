<?php

require("../../../includes/adminConfig.php");

$tableID = isset($_GET["tableID"]) ? htmlspecialchars($_GET["tableID"]) : null;
if( !exists("_table", $tableID) ) {
	redirect("");
}

$query = "SELECT
    tbl._number, C.name AS clubName,
    tbl.status AS tableStatus, MD.status AS matchStatus,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    X.photo AS photo1, Y.photo AS photo2,
    M.player1Score, M.player2Score, M.bestOf,
    LM.points1, LM.points2, LM.break1, LM.break2,
    C.photo AS clubPhoto, M.id, C.id AS clubID
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    LEFT JOIN matchDetails MD ON MD.matchID = tbl.matchID
    LEFT JOIN liveMatch LM ON LM.matchID = tbl.matchID
    JOIN club C ON tbl.clubID = C.id
WHERE tbl.id=?";

$data = query($query, $tableID);

$tableNum = $data[0][0]; $clubName = $data[0][1];
$tableStatus = $data[0][2]; $matchStatus = $data[0][3];

$player1 = $data[0][4]; $player2 = $data[0][5];
$img1 = $data[0][6]; $img2 = $data[0][7];

$score1 = $data[0][8]; $score2 = $data[0][9]; 
$bestOf = $data[0][10];

$points1 = $data[0][11]; $points2 = $data[0][12];
$break1 = $data[0][13]; $break2 = $data[0][14];

$club_img = $data[0][15]; $clubID = $data[0][16];


if( !strcmp($tableStatus, "Occupied") )
{
	redirect(PATH_H."admin/clubs/live-match-lobby.php?tableID=$tableID"); 
}
else if( !strcmp($tableStatus, "SparringOccupied") )
{
	$player1class = "live-match-lobby-player";
	$player2class = "live-match-lobby-player";

	$matchInfo = "Спаринг";

	if( !strcmp($matchStatus, "Live") ) {
		nonEmpty($break1) ? ($player1class .= " highlight") :
		($player2class .= " highlight");

		require("sparring/live_sparring.html");
	}
	else if( !strcmp($matchStatus, "Finished") )
		require("sparring/finished_sparring.html");
}
else
{
	require("sparring/empty_sparring.html");
}

?>
