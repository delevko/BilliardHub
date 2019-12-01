<?php
require("../../includes/config.php");


$tableID = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : NULL;
if( !nonEmpty($tableID) || !exists("_table", $tableID) )
	redirect("");

$query = "SELECT
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player1Score, M.player2Score, M.bestOf,
    LM.points1, LM.points2, LM.break1
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    LEFT JOIN liveMatch LM ON LM.matchID = tbl.matchID
WHERE tbl.id = ?";

$data = query($query, $tableID);

$player1 = $data[0][0]; $player2 = $data[0][1];
$frames1 = $data[0][2]; $frames2 = $data[0][3];
$bestOf = $data[0][4];

$points1 = $data[0][5]; $points2 = $data[0][6];
$break1 = $data[0][7];

$result = 
'{
    "name1" : "'.$player1.'",
    "name2" : "'.$player2.'",
    "frames1" : "'.$frames1.'",
    "frames2" : "'.$frames2.'",
    "points1" : "'.$points1.'",
    "points2" : "'.$points2.'",
    "break1" : "'.$break1.'",
    "bestOf" : "'.$bestOf.'"
}';

echo $result;

?>
