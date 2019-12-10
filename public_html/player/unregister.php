
<?php

require("../../includes/userConfig.php");
$login = $_SESSION["id"]["login"];

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $tournamentID = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : NULL;

    if( !nonEmpty($tournamentID) || !exists("tournament", $tournamentID) )
    {
	redirect(PATH_H."logout.php");
    }


    $query="SELECT 1 FROM playerTournament PT
	WHERE PT.playerID=(SELECT U.playerID FROM _user U WHERE U.login=?)
	AND PT.tournamentID=?";
    if(count(query($query, $login, $tournamentID)) < 1)
    {
        redirect(PATH_H."tournaments/lobby.php?id=$tournamentID");
    }


    $query = "DELETE FROM playerTournament
	WHERE playerID=(SELECT U.playerID FROM _user U WHERE U.login=?)
	AND tournamentID=?";
    query($query, $login, $tournamentID);

    sleep(0.5);
    redirect(PATH_H."tournaments/lobby.php?id=$tournamentID");
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    redirect(PATH_H."logout.php");
}


?>
