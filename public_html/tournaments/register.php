
<?php

require("../../includes/userConfig.php");
$login = $_SESSION["id"]["login"];

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if( !nonEmpty($_GET["id"]) ||
	!exists("tournament", $_GET["id"]))
    {
	redirect(PATH_H."logout.php");
    }

    $tournamentID = $_GET["id"];


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

    sleep(1);
    redirect("lobby.php?id=$tournamentID");
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    redirect(PATH_H."logout.php");
}


?>
