<?php

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$leagueID = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : null;
	if( !nonEmpty($leagueID) || !exists("league", $leagueID) )
		redirect("");


	render("rankings/ranking.php", ["leagueID"=>$leagueID, "title"=>"Рейтинг"]);
}
else
{
	redirect("");
}
