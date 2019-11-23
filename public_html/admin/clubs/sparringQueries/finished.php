<?php

require("../../../../includes/adminConfig.php");

$action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : null;
$tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : null;
foreach ($_POST as $l=>$v){
	unset($_POST[$l]);
}

if( nonEmpty($tableID) && exists("_table", $tableID) )
{
	if( !strcmp($action, "repeatSparring") ) {
		repeatSparring($tableID);
        }

	else if( !strcmp($action, "exitMatch") ) {
		exitMatch($tableID);	
	}
	else
	    redirect(PATH_H."logout.php");
	
	redirect(PATH_H."admin/clubs/live-match-lobby.php?tableID=$tableID");
}


function repeatSparring($tableID)
{
    $query = "CALL repeatSparringTable(?)";
    $data = query($query, $tableID);

}

function exitMatch($tableID)
{
    $query = "CALL clearTable(?)";
    query($query, $tableID);
}

?>
