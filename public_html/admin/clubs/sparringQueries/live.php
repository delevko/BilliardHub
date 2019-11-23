<?php

require("../../../../includes/adminConfig.php");

$isLeft = isset($_POST["currPlayer"]) ? htmlspecialchars($_POST["currPlayer"]) : null;
$action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
$points = isset($_POST["points"]) ? htmlspecialchars($_POST["points"]) : null;
$break = isset($_POST["_break"]) ? htmlspecialchars($_POST["_break"]) : null;
$tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : null;

if( nonEmpty($tableID) && exists("_table", $tableID) )
{
	if( !strcmp($action, "finishFrame") ) {
		changePlayer($isLeft, $tableID, $break);
		finishFrame($tableID);

		sleep(0.5);
		redirect(PATH_H."admin/clubs/sparring-lobby.php?tableID=$tableID");
	}

	$rlt = array();
	foreach ($_POST as $l=>$v){
		$rlt[$l] = $v;
	}
	foreach ($_POST as $l=>$v){
		unset($_POST[$l]);
	}

	if( !strcmp($action, "changePlayer") ) {
		
		array_push($rlt, changePlayer($isLeft, $tableID, $break));
	}
	else if( !strcmp($action, "breakIncrement") ) {
	
		array_push($rlt, breakIncrement($isLeft, $tableID, $points));
	}

	die( json_encode($rlt) );
}
else
	redirect(PATH_H."logout.php");


function changePlayer($isLeft, $tableID, $break){

	$rlt = array();

	if($isLeft == "true"){
		$rlt["request"] = "CALL changeSparringPlayer(?,true,?)";
	}else if($isLeft == "false"){
		$rlt["request"] = "CALL changeSparringPlayer(?,false,?)";
	}

	$rlt["erreur"] = false;

	if( !JSquery($rlt["request"], $tableID, $break) )
		$rlt["erreur"] = "Database unsuccessful";

	return $rlt;
}

function breakIncrement($isLeft, $tableID, $points){

	$rlt = array();

	if($isLeft == "true"){
		$rlt["request"] = "CALL breakIncrement(?,true,?)";
	}else if($isLeft == "false"){
		$rlt["request"] = "CALL breakIncrement(?,false,?)";
	}

	$rlt["erreur"] = false;

	if( !JSquery($rlt["request"], $tableID, $points) )
		$rlt["erreur"] = "Database unsuccessful";

	return $rlt;
}

function finishFrame($tableID){
	$query = "CALL finishFrame(?)";
	query($query, $tableID);
}

?>
