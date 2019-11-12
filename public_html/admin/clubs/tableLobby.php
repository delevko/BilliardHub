<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$tableID = $_GET["id"];

	if( exists("_table", $tableID) )
	{
		lobbyGenerate($tableID);
	}
	else
	{
		redirect("");
	}
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$tableID = $_POST["id"];	

	if(exists("_table", $tableID))
	{
	//occupied && live
		if(isset($_POST["reset"]))
		{
			query("CALL resetTable(?)", $tableID);
		}
	//occupied && finished
		else if(isset($_POST["exit"]))
		{
			$query = "UPDATE _table T SET T.status=?, matchID=NULL WHERE T.id=?";
			query($query, "Available", $tableID);
		}
	//occupied && finished
		else if(isset($_POST["next"]))
		{
			$tournamentID = $_POST["tournament"];
			$flag = true;
			query("CALL occupyNext(?, ?)", $tableID, $tournamentID);
		}
	//available
		else if(isset($_POST["match"]))
		{
			$matchID = $_POST["matchID"];
			query("CALL setMatchTable(?,?)", $matchID, $tableID);
		}

		redirect("tableLobby.php?id=$tableID");
	}
	else
	{
		redirect("");
	}
}


function lobbyGenerate($tableID)
{
	$query = "SELECT tbl._number, tbl.status, tbl.clubID,
		C.name AS clubName, C.photo AS clubPhoto
		FROM _table tbl JOIN club C ON tbl.clubID=C.id
		WHERE tbl.id=?";
	$data = query($query, $tableID);

	$clubPhoto = $data[0][4];	
	$clubID = $data[0][2]; $clubName = $data[0][3];
	$tableStatus = $data[0][1];
	$tableNum = $data[0][0];

	adminRender("clubs/tableLobby.php",
		["title"=>$clubName.": ".$tableNum, "tableID"=>$tableID,
		"clubName"=>$clubName, "clubID"=>$clubID, "clubPhoto"=>$clubPhoto,
		"tableStatus"=>$tableStatus, "tableNum"=>$tableNum]);
}
?>
