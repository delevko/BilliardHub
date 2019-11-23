<?php
require("../../../../includes/adminConfig.php");


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $tableID = isset($_POST["tableID"]) ? htmlspecialchars($_POST["tableID"]) : NULL;
    $player1ID = isset($_POST["1ID"]) ? htmlspecialchars($_POST["1ID"]) : NULL;
    $player2ID = isset($_POST["2ID"]) ? htmlspecialchars($_POST["2ID"]) : NULL;
    $bestOF = isset($_POST["bestOF"]) ? htmlspecialchars($_POST["bestOF"]) : NULL;

    if( !nonEmpty($tableID) || !exists("_table", $tableID) )
        redirect(PATH_H."logout.php");

    if( !nonEmpty($player1ID, $player2ID, $bestOF) || $bestOF < 1 )
         redirect(PATH_H."admin/clubs/sparring-lobby.php?tableID=$tableID");

    if( !exists("player", $player1ID) || !exists("player", $player2ID) )
         redirect(PATH_H."admin/clubs/sparring-lobby.php?tableID=$tableID");

    $query = "CALL startSparring(?,?,?,?)";
    query($query, $tableID, $player1ID, $player2ID, $bestOF);

    redirect(PATH_H."admin/clubs/sparring-lobby.php?tableID=$tableID");
}
else
    redirect(PATH_H."logout.php");

?>
