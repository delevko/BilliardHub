<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("other/billiardForm.php",["title"=>"Create billiard"]);
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["name"];
	if( !nonEmpty($name) )
	{
		adminApology(INPUT_ERROR, "Name is required");
		exit;
	}
	if( count(query("select 1 from billiard where name=?", $name)) )
	{
		adminApology(INPUT_ERROR, "This billiard exists");
		exit;
	}
	
	query("INSERT INTO billiard(name) VALUES(?)", $name);
	redirect(PATH_H."admin/other");
}

?>
