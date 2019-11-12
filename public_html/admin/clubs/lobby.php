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
	$clubID = $_POST["club"];
	if( exists("club", $clubID) )
	{
		if(isset($_POST["occupy"]))
		{
			$tournamentID = $_POST["tournament"];
			query("CALL clubTablesOccupy(?,?)", $clubID, $tournamentID);
		}
		redirect("lobby.php?id=$clubID");
	}

	redirect(PATH_H."admin/");
}
?>
