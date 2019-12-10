<?php
require("../../../includes/adminConfig.php");


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $tournament = $_POST["tournamentID"];
    $description = $_POST["description"];

    if(!nonEmpty($tournament, $description))
    {
	redirect(PATH_H."logout.php");
    }

    $query="UPDATE tournament_details SET description=? WHERE tournamentID=?";
    query($query, $description, $tournament);

    redirect(PATH_H."admin/tournaments/lobby.php?id=$tournament");
}
else if($_SERVER["REQUEST_METHOD"] == "GET")
{
	redirect(PATH_H."logout.php");
}

?>

