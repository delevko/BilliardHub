<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	list($tournamentID) = checkData($_POST["tournamentID"]);
	unset($_POST["tournamentID"]);

	print_r($_POST);

	$query1 = "UPDATE playerTournament PT SET PT.seed=";
	$query3 = " WHERE PT.tournamentID=? AND PT.playerID=?";
	
	foreach( $_POST as $player => $seed )
	{
		$query2 = nonEmpty($seed) ? $seed : "NULL";
		$query = $query1 . $query2 . $query3;
		query($query, $tournamentID, $player);
	}
	redirect(PATH_H."admin/tournaments/lobby.php?id=$tournamentID&onClick=participants");
}
else
{
	redirect(PATH_H."logout.php");
}



function checkData($id)
{
	if( !nonEmpty($id) || !exists("tournament", $id) )
		redirect(PATH_H."logout.php");

	return array($id);
}

?>
