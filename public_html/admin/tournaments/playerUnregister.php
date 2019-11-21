
<?php
require("../../../includes/adminConfig.php");


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $tournament = $_POST["tournament"];
    $player = $_POST["player"];

    if(!nonEmpty($tournament, $player))
    {
        adminApology(INPUT_ERROR, "Необхідно заповнити всі поля");
        exit;
    }
    $query="select 1 from playerTournament where playerID=? AND tournamentID=?";
    if(count(query($query, $player, $tournament)) < 1)
    {
        adminApology(INPUT_ERROR, "Цей гравець не є зареєстрований в турнірі");
        exit;
    }

    $query = "DELETE FROM playerTournament WHERE tournamentID=? AND playerID=?";
    query($query, $tournament, $player);
    redirect("lobby.php?id=$tournament&onClick=register");
}
else if($_SERVER["REQUEST_METHOD"] == "GET")
{
	redirect(PATH_H."logout.php");
}

?>

