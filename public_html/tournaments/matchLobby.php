<?php 

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$matchID = isset($_GET["id"]) ? $_GET["id"] : null;
	if( exists("_match", $matchID) )
	{
		render("tournaments/matchLobby.php", ["title" => "Зустріч", "matchID"=>$matchID]);
	}
	else
	{
		redirect("");
	}
}
else
{
	redirect("");
}

?>
