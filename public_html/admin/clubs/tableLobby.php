<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$tableID = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : NULL;

	if( nonEmpty($tableID) && exists("_table", $tableID) )
	{
		lobbyGenerate($tableID);
	}
	else
	{
		redirect(PATH_H."logout.php");
	}
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$tableID = isset($_POST["id"]) ? htmlspecialchars($_POST["id"]) : NULL;

	if( nonEmpty($tableID) && exists("_table", $tableID) )
	{
	//occupied && live
		if(isset($_POST["reset"]))
		{
			query("CALL resetTable(?)", $tableID);
		}
	//sparringOccupied && live
		else if(isset($_POST["sparringReset"]))
		{
			query("CALL resetSparringTable(?)", $tableID);
		}
	//sparringOccupied && finished
		else if(isset($_POST["sparringRepeat"]))
		{
			query("CALL repeatSparringTable(?)", $tableID);
		}
	//occupied && finished
		else if(isset($_POST["exit"]))
		{
			$query = "UPDATE _table T SET T.status=?, youtube=NULL, matchID=NULL
				WHERE T.id=?";
			query($query, "Available", $tableID);
		}
	//occupied && finished
		else if(isset($_POST["next"]))
		{
		    $query = "SELECT M.tournamentID, MD.status
                FROM _match M JOIN matchDetails MD ON M.id=MD.matchID
                WHERE M.id = 
                (SELECT T.matchID FROM _table T WHERE T.id=?)";
                    $data = query($query, $tableID);
                    $tournamentID = $data[0][0]; $status = $data[0][1];

                    if($status == "Finished")
                    {
			query("CALL occupyNext(?, ?)", $tableID, $tournamentID);
		    }
		}
	//available
		else if(isset($_POST["match"]))
		{
			$matchID = $_POST["matchID"];
			query("CALL setMatchTable(?,?)", $matchID, $tableID);
		}

		redirect(PATH_H."admin/clubs/tableLobby.php?id=$tableID");
	}
	else
	{
		redirect(PATH_H."logout.php");
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
