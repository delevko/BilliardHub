<?php

require("../../../../includes/adminConfig.php");

$action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
$tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : null;
foreach ($_POST as $l=>$v){
	unset($_POST[$l]);
}

if( exists("_table", $tableID) )
{
	if( !strcmp($action, "nextMatch") ) {
		$query = "SELECT M.tournamentID, MD.status
		FROM _match M JOIN matchDetails MD ON M.id=MD.matchID
		WHERE M.id = (SELECT T.matchID FROM _table T WHERE T.id=?)";
		$data = query($query, $tableID);
		if(count($data) < 1)
	    	    redirect(PATH_H."logout.php");

		$tournamentID = $data[0][0]; $status = $data[0][1];
		if($status == "Finished")
		    nextMatch($tableID, $tournamentID);
        }

	else if( !strcmp($action, "exitMatch") ) {
		exitMatch($tableID);	
	}
	else
	    redirect(PATH_H."logout.php");
	
	sleep(0.5);
	redirect(PATH_H."admin/clubs/live-match-lobby.php?tableID=$tableID");
}


function nextMatch($tableID, $tournamentID)
{
    $query = "CALL occupyNext(?,?)";
    query($query, $tableID, $tournamentID);

}

function exitMatch($tableID)
{
    $query = "CALL clearTable(?)";
    query($query, "Available", $tableID);
}

?>
