<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("forms/tournament.php", ["title" => "Створити турнір"]);
}	
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["name"];
	$leagueID = $_POST["league"];
	$clubID = $_POST["club"];

	if(!nonEmpty($name, $leagueID, $clubID))
	{
		adminApology(INPUT_ERROR, "Необхідно заповнити всі поля");
		exit;
	}
	if( !exists("league", $leagueID) || !exists("club", $clubID) )
	{
		redirect(PATH_H."admin/");
	}
	

	if(count(query("select 1 from tournament where name=? and leagueID=? LIMIT 1", $name, $leagueID)))
	{
		adminApology(INPUT_ERROR, "Неможливо створити турнір. Спробуйте змінити одне з полів.");
		exit;
	}


	if(!$_POST["begDate"] || !$_POST["endDate"])
    {
        adminApology(INPUT_ERROR, "Необхідно ввести дату початку та закінчення турніру");
        exit;
    }

	$begDate = date('Y:m:d', strtotime($_POST["begDate"]) );
	$endDate = date('Y:m:d', strtotime($_POST["endDate"]) );
    if(!$begDate || !$endDate)
    {
        adminApology(INPUT_ERROR, "Помилка дати");
        exit;

    }

	

	$query = "INSERT INTO tournament(name,leagueID,clubID,startDate,endDate)
		VALUES(?,?,?,?,?)";
	
	query($query, $name, $leagueID, $clubID, $begDate, $endDate);
	redirect(PATH_H."admin/");
}

?>
