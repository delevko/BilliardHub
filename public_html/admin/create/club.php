<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("forms/club.php", ["title" => "Додати клуб"]);
}	
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["name"];
	$country = $_POST["country"];
	$city = $_POST["city"];
	$tables = $_POST["tables"];


	if( !nonEmpty($name, $country, $city, $tables) )
	{
		adminApology(INPUT_ERROR, "Необхідно заповнити всі поля");
		exit;
	}

	if( !$_FILES["photo"]["size"] )
    {
        $photo = "default.png";
    }
    else
    {
        $photo = $name . ".jpg";
        $filepath = HOME_DIR . "public_html/img/club/" . $photo;

        if( !getimagesize($_FILES["photo"]["tmp_name"]) )
        {
            adminApology(INPUT_ERROR, "Завантажте фото");
            exit;
        }
        if( !move_uploaded_file($_FILES["photo"]["tmp_name"], $filepath) )
        {
            adminApology(INPUT_ERROR, "Помилка фотографії "." ".$filepath." ".$_FILES["photo"]["name"]);
            exit;
        }
    }




	
	$query = "INSERT INTO club(name, country, city, nrOfTables, photo) 
			VALUES(?,?,?,?,?)";
	
	query($query, $name, $country, $city, $tables, $photo);
	redirect(PATH_H."admin/");
}

?>
