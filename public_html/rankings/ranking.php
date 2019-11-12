<?php

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$leagueID = $_GET["id"];
	if( !exists("league", $leagueID) )
		redirect("");



	render("rankings/ranking.php", ["leagueID"=>$leagueID, "title"=>"Рейтинг"]);
}
else
{
	redirect("");
}
