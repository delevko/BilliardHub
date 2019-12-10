
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
    if(count(query($query, $login, $tournamentID)) > 0)
    {
        apology(INPUT_ERROR, "Ð’Ð ÐÐÐµÐÐÑ€ÐÑ”ÑÑ‚Ñ€ÐÐÐÐÑ–");
        exit;
    }

    $query = "INSERT INTO playerTournament(tournamentID, playerID)
	VALUES(?, (SELECT U.playerID FROM _user U WHERE U.login=?))";
    query($query, $tournamentID, $login);

    sleep(0.5);
    redirect(PATH_H."tournaments/lobby.php?id=$tournamentID");
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    redirect(PATH_H."logout.php");
}


?>
