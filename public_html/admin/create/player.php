<?php
require("../../../includes/adminConfig.php");
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	adminRender("forms/player.php", ["title" => "Додати гравця"]);
}
else if($_SERVER["REQUEST METHOD"] = "POST")
{
    $fName = $_POST["first"];
    $lName = $_POST["last"];
    if( !nonEmpty($fName, $lName) )
	{
        adminApology(INPUT_ERROR, "Введіть ім'я та прізвище");
        exit;
    }
    if(!$_POST["birthday"])
    {
        adminApology(INPUT_ERROR, "Введіть дату народження");
        exit;
    }
    $birthday = date('Y-m-d', strtotime($_POST["birthday"]) );
    if( !$birthday)
    {
        adminApology(INPUT_ERROR, "Помилка дати");
        exit;
    }
	
    $city = $_POST["city"];
    $country = $_POST["country"];
    if( !nonEmpty($city, $country) )
	{
        adminApology(INPUT_ERROR, "Введіть країну та місто");
        exit;
    }
	if( !$_FILES["photo"]["size"] )
	{
		$photo = "default.png";
	}
	else
	{
		$photo = $fName . "_" . $lName . ".jpg";
		$filepath = HOME_DIR . "public_html/img/player/" . $photo;
   
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
 
	$query = "INSERT INTO player(firstName, lastName, photo, birthday, city, country) VALUES(?,?,?,?,?,?)";
    
	query($query, $fName, $lName, $photo, $birthday, $city, $country);
    redirect(PATH_H."admin/");
}
?>
