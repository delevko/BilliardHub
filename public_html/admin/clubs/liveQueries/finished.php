<?php

require("../../../../includes/adminConfig.php");

$action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
$tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : null;

if( exists("_table", $tableID) )
{
	$rlt = array();
	foreach ($_POST as $l=>$v){
		$rlt[$l] = $v;
	}
	foreach ($_POST as $l=>$v){
		unset($_POST[$l]);
	}

	if( !strcmp($action, "nextMatch") ) {
		$query = "SELECT M.tournamentID, MD.status
		FROM _match M JOIN matchDetails MD ON M.id=MD.matchID
		WHERE M.id = 
			(SELECT T.matchID FROM _table T WHERE T.id=?)";
		$data = query($query, $tableID);
		$tournamentID = $data[0][0]; $status = $data[0][1];

		if($status == "Finished")
		{
		    $rlt["request"] = "CALL occupyNext(?,?)";
		    $rlt["erreur"] = false;
	
		    if( !JSquery($rlt["request"], $tableID, $tournamentID) )
			$rlt["erreur"] = "Database unsuccessful";
	
		    die( json_encode($rlt) );
		}
		else
			header("Refresh:0");
		sleep(1);
        }

	else if( !strcmp($action, "exitMatch") ) {
		
		$rlt["request"] = "UPDATE _table T SET T.status=? WHERE T.id=?";
		$rlt["erreur"] = false;
	
		if( !JSquery($rlt["request"], "Available", $tableID) )
			$rlt["erreur"] = "Database unsuccessful";
	
		die( json_encode($rlt) );
	}
	die();
}

?>
