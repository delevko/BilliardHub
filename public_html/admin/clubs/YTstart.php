<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	redirect("");
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$tableID = $_POST["tableID"];	
	$matchID = $_POST["matchID"];	

	if( !exists("_table", $tableID) || !exists("_match", $matchID) )
		redirect("");

	$matchHeader = getHeader($tableID);

	if(!nonEmpty($_POST["URL"]))
	{
		apology(INPUT_ERROR, "Введіть адресу URL трансляції на Youtube");
		exit;
	}
	$youtube = $_POST["URL"]; //"-zZbkPnBtS8";
	
	query("UPDATE _match M SET M.youtube=? WHERE M.id=?", $youtube, $matchID);

	redirect("tableLobby.php?id=$tableID");	
}


function getHeader($tableID)
{
	$query = "SELECT
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    T.name AS tournamentName
	FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN tournament T ON M.tournamentID = T.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
	WHERE tbl.id=?";

	$data = query($query, $tableID);
	$player1 = $data[0][0]; $player2 = $data[0][1];
	$tournament = $data[0][2];

	$header = $player1." v ".$player2." ".$tournament;

	return $header;
}

?>
