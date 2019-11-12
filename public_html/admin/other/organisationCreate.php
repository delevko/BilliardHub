<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("other/organisationForm.php", ["title" => "Create organisation"]);
}	
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["name"];
	if( !nonEmpty($name) )
	{
		adminApology(INPUT_ERROR, "Name is required");
		exit;
	}

	if(count(query("select * from organisation where name=?",$name))>0)
	{
		adminApology(INPUT_ERROR, "This organisation exists");
		exit;
	}
	
	query("INSERT INTO organisation(name) VALUES(?)", $name);
	redirect(PATH_H."admin/other");
}

?>
