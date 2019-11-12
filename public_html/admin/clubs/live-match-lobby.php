<?php

require("../../../includes/adminConfig.php");

$tableID = isset($_GET["tableID"]) ? htmlspecialchars($_GET["tableID"]) : null;
if( !exists("_table", $tableID) ) {
	redirect("");
}

$query = "SELECT
    tbl._number, C.name AS clubName,
    tbl.status AS tableStatus, MD.status AS matchStatus,
    M.counter AS matchCounter,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player1Score, M.player2Score, M.bestOf,
    T.name AS tournamentName,
    LM.points1, LM.points2, LM.break1, LM.break2,
    M.roundType, M.roundNo, M.groupID,
    X.photo AS photo1, Y.photo AS photo2,
    C.photo AS clubPhoto
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
$club_img = $data[0][20];

$tableStatus = $data[0][2]; $matchStatus = $data[0][3]; $matchNum = $data[0][4];
$player1 = $data[0][5]; $player2 = $data[0][6]; $bestOf = $data[0][9];
$score1 = $data[0][7]; $score2 = $data[0][8]; 
$points1 = $data[0][11]; $points2 = $data[0][12]; $break1 = $data[0][13]; $break2 = $data[0][14];
$roundType = $data[0][15]; $roundNo = $data[0][16]; $groupID = $data[0][17];
$img1 = $data[0][18]; $img2 = $data[0][19];

$player1class = "live-match-lobby-player"; $player2class = "live-match-lobby-player";
( nonEmpty($break1) ) ? ($player1class .= " highlight") : ($player2class .= " highlight");

$matchInfo = matchInfo($roundType, $roundNo, $groupID);

if( !strcmp($tableStatus, "Occupied") ) { 
	if( !strcmp($matchStatus, "Live") ){
		require("live_match.html");
	}
	else if( !strcmp($matchStatus, "Finished") ){
		require("finished_match.html");
	}
}
else {
	redirect("tableLobby.php?id=$tableID");
}

//liveSparringLobby finishedSparringLobby
//if tableStatus="available" -> availableSparringLobby

function matchInfo($roundType, $roundNo, $groupID){
	if( !strcmp($roundType, "Group") ){
		$data = query("SELECT G.groupNum FROM groupTournament G WHERE G.id=?", $groupID);
		$roundNo = $data[0][0];
	}

	$info = castMatchHeader($roundType).$roundNo;


	return $info;
}

?>
