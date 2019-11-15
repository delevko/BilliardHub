<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("forms/league.php", ["title" => "Додати лігу"]);
}	
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["name"];
	$billiard = $_POST["billiard"];
	$age = $_POST["age"];
	$org = $_POST["organisation"];
	$sex = $_POST["sex"];

	if( !nonEmpty($name, $billiard, $org, $age) )
	{
		adminApology(INPUT_ERROR, "Необхідно заповнити всі поля");
		exit;
	}
	
	if( !exists("billiard", $billiard) )
	{
		adminApology(INPUT_ERROR, "Помилка більярду");
		exit;
	}
	if( !exists("organisation", $org) )
	{
		apology(INPUT_ERROR, "Помилка організації");
		exit;
	}
	if( !exists("age", $age) )
	{
		apology(INPUT_ERROR, "Помилка віку");
		exit;
	}


	$q = "SELECT 1 FROM league WHERE name=? AND billiardID=? 
		  AND ageID=? AND organisationID=? AND sexID=?";

	$data = query($q, $name, $billiard, $age, $org, $sex);
	if(count($data) > 0)
	{
		adminApology(INPUT_ERROR, "Для даної організації існує ліга з такою назвою");
		exit;
	}
	
	
	$query = "INSERT INTO league(name, ageID, sexID, billiardID, organisationID) VALUES(?,?,?,?,?)";
	query($query, $name, $age, $sex, $billiard, $org);
	redirect(PATH_H."admin/");
}

?>
