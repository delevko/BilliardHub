<?php

require("../../../../includes/adminConfig.php");

$isLeft = isset($_POST["currPlayer"]) ? htmlspecialchars($_POST["currPlayer"]) : null;
$action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
$points = isset($_POST["points"]) ? htmlspecialchars($_POST["points"]) : null;
$break = isset($_POST["_break"]) ? htmlspecialchars($_POST["_break"]) : null;
$tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : null;
foreach ($_POST as $l=>$v){
	unset($_POST[$l]);
}


if( exists("_table", $tableID) )
{
	$rlt = array();
	foreach ($_POST as $l=>$v){
		$rlt[$l] = $v;
	}

	if( !strcmp($action, "changePlayer") ) {
		
		array_push($rlt, changePlayer($isLeft, $tableID, $break));
	}
	else if( !strcmp($action, "breakIncrement") ) {
	
		array_push($rlt, breakIncrement($isLeft, $tableID, $points));
	}
	else if( !strcmp($action, "finishFrame") ) {

		array_push($rlt, changePlayer($isLeft, $tableID, $break));
		array_push($rlt, finishFrame($tableID));
	}

	die( json_encode($rlt) );
}


function changePlayer($isLeft, $tableID, $break){

	$rlt = array();

	if($isLeft == "true"){
		$rlt["request"] = "CALL changePlayer(?,true,?)";
	}else if($isLeft == "false"){
		$rlt["request"] = "CALL changePlayer(?,false,?)";
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

	$rlt = array();

	$rlt["request"] = "CALL finishFrame(?)";
	$rlt["erreur"] = false;

	if( !JSquery($rlt["request"], $tableID) )
		$rlt["erreur"] = "Database unsuccessful";

	return $rlt;
}

?>
