<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$clubID = $_GET["id"];
	if( exists("club", $clubID) )
	{
		$query = "SELECT C.name, C.photo FROM club C WHERE id=?";
		$data = query($query, $clubID);
		$clubName = $data[0][0]; $clubPhoto = $data[0][1];

		adminRender("clubs/lobby.php", ["title"=>$clubName, "clubName"=>$clubName, "clubID"=>$clubID, "clubPhoto"=>$clubPhoto]);
	}
	else
	{
		redirect("");
	}
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if( nonEmpty($_POST["club"]) && exists("club", $_POST["club"]) )
	{
		$clubID = $_POST["club"];
		if(isset($_POST["occupy"]))
		{
			if( nonEmpty($_POST["tournament"]) && exists("tournament", $_POST["tournament"]) )
			{
				$tournamentID = $_POST["tournament"];
				query("CALL clubTablesOccupy(?,?)", $clubID, $tournamentID);
			}
		}
		redirect("lobby.php?id=$clubID");
	}

	redirect(PATH_H."admin/");
}
?>
