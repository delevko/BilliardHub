<?php

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$clubID = $_GET["id"];
	if( exists("club", $clubID) )
	{
		$query = "SELECT C.name, C.photo FROM club C WHERE id=?";
		$data = query($query, $clubID);
		$clubName = $data[0][0]; $clubPhoto = $data[0][1];


		render("clubs/lobby.php", ["title"=>$clubName, "clubName"=>$clubName, "clubID"=>$clubID, "clubPhoto"=>$clubPhoto]);
	}
	else
	{
		redirect("");
	}
}
else
{
	redirect("");
}
?>
