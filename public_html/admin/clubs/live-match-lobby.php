<?php

require("../../../includes/adminConfig.php");

$tableID = isset($_GET["tableID"]) ? htmlspecialchars($_GET["tableID"]) : null;
if( !exists("_table", $tableID) ) {
	redirect("");
}

sleep(1);

$query = "SELECT
    tbl._number, C.name AS clubName,
    tbl.status AS tableStatus, MD.status AS matchStatus,
    M.counter AS matchCounter,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player1Score, M.player2Score, M.bestOf,
    T.name AS tournamentName,
    LM.points1, LM.points2, LM.break1, LM.break2,
    M.roundType,
    X.photo AS photo1, Y.photo AS photo2,
    C.photo AS clubPhoto, M.id, C.id AS clubID
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN tournament T ON M.tournamentID = T.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    LEFT JOIN matchDetails MD ON MD.matchID = tbl.matchID
    LEFT JOIN liveMatch LM ON LM.matchID = tbl.matchID
    JOIN club C ON tbl.clubID = C.id
WHERE tbl.id=?";

$data = query($query, $tableID);

$tableNum = $data[0][0]; $clubName = $data[0][1];
$club_img = $data[0][18]; $clubID = $data[0][20];

$tableStatus = $data[0][2]; $matchStatus = $data[0][3];
$matchNum = $data[0][4]; $matchID = $data[0][19];
$roundType = $data[0][15];

$player1 = $data[0][5]; $player2 = $data[0][6];
$img1 = $data[0][16]; $img2 = $data[0][17];

$bestOf = $data[0][9];
$score1 = $data[0][7]; $score2 = $data[0][8]; 
$points1 = $data[0][11]; $points2 = $data[0][12];
$break1 = $data[0][13]; $break2 = $data[0][14];


if( !strcmp($tableStatus, "Occupied") )
{ 
	$player1class = "live-match-lobby-player";
	$player2class = "live-match-lobby-player";

	$matchInfo = matchInfo($matchID, $roundType);

	if( !strcmp($matchStatus, "Live") ) {
		nonEmpty($break1) ? ($player1class .= " highlight") :
		($player2class .= " highlight");

		require("live_match.html");
	}
	else if( !strcmp($matchStatus, "Finished") )
		require("finished_match.html");
}
else if( !strcmp($tableStatus, "SparringOccupied") )
{
	$player1class = "live-match-lobby-player";
	$player2class = "live-match-lobby-player";

	$matchInfo = "Спаринг";

	if( !strcmp($matchStatus, "Live") ) {
		nonEmpty($break1) ? ($player1class .= " highlight") :
		($player2class .= " highlight");

		require("live_sparring.html");
	}
	else if( !strcmp($matchStatus, "Finished") )
		require("finished_sparring.html");
}
else
{
	require("empty_match.html");
}


//liveSparringLobby finishedSparringLobby
//if tableStatus="available" -> availableSparringLobby

function matchInfo($id, $rType)
{
    $grpORround = ($rType=="Group") ? "GT.groupNum" : "M.roundNo";
    $query = "SELECT ".$grpORround.", T.KO_Rounds, T.seeded_Round
   FROM _match M JOIN tournament T ON M.tournamentID=T.id
   LEFT JOIN groupTournament GT ON M.groupID = GT.id
   WHERE M.id=?";
    $data = query($query, $id);
    $rndNo = $data[0][0]; $KO_R = $data[0][1];
    $seeded_R = $data[0][2];

    $header = castHeader($rType, $rndNo, $KO_R, $seeded_R);
    return $header;
}

?>
