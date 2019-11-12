<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("matches/form.php", ["title" => "Create match"]);
}	
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$pl1ID = $_POST["player1"];
	$pl2ID = $_POST["player2"];
	$clubID = $_POST["club"];
	$bestOF = $_POST["bestOF"];

	$hand1 = $_POST["hand1"];
	$hand2 = $_POST["hand2"];
	
	if( !nonEmpty($pl1ID, $pl2ID, $clubID, $bestOF, $hand1, $hand2) )
	{
		adminApology(INPUT_ERROR, "All fields are required");
		exit;
	}

	if( count(query("select 1 from player where id=? or id=?", $pl1ID, $pl2ID)) !== 2)
	{
		adminApology(INPUT_ERROR, "Inappropriate players");
		exit;
	}
	if( !exists("club", $clubID))
	{
		adminApology(INPUT_ERROR, "Inappropriate club");
		exit;
	}

	$billiardID = $data[0][0];
	$ageID = $data[0][1];
	$sex = $data[0][2];
	
	$query = "INSERT INTO _match(player1ID, player2ID, player1Score, player2Score, clubID, bestOF) VALUES(?,?,?,?,?,?)";
	
	query($query, $pl1ID, $pl2ID, $hand1, $hand2, $clubID, $bestOF);

	redirect(PATH_H."admin/matches");
}

?>
