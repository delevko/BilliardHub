
<?php

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $matchID = isset($_GET["id"]) ? $_GET["id"] : null;
    if( !nonEmpty($matchID) || !exists("_match", $matchID) )
    {
        redirect("");
    }

    render("players/sparringLobby.php", [
	"title"=>"Спаринг",
	"matchID"=>$matchID]);
}
else
{
    redirect("");
}
?>
