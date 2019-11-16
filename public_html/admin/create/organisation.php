<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("forms/organisation.php",
	["title" => "Додати організацію"]);
}
else if($_SERVER["REQUEST METHOD"] = "POST")
{
    if( !nonEmpty($_POST["name"]) )
    {
        adminApology(INPUT_ERROR, "Введіть назву організації");
        exit;
    }
    $name = $_POST["name"];

    $query = "SELECT 1 FROM organisation O WHERE O.name=?";
    $data = query($query, $name);
    if( count($data) > 0 )
    {
	adminApology(INPUT_ERROR, "Ви ввели вже існуючу назву");
	exit;
    }


    $query = "INSERT INTO organisation(name) VALUES(?)";
    query($query, $name);
    redirect(PATH_H."admin/");
}

?>
