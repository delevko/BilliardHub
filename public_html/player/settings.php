
<?php

require("../../includes/userConfig.php");
$login = $_SESSION["id"]["login"];

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$title = "Налаштування $login";

	$query = "SELECT P.id
	FROM player P JOIN _user U ON P.id=U.playerID
	WHERE U.login=?";
	$data = query($query, $login);
	$id = $data[0][0];

	list($fName, $lName, $img, $birthday, $country, $city)
		 = getPlayer($id); 
	
	$title = $lName." ".$fName;

	render("player/settings.php",
	["title"=>$title, "name"=>$title,
	"fName"=>$fName, "lName"=>$lName,
	"photo"=>$img, "playerID"=>$id, "birthday"=>$birthday,
	"country"=>$country, "city"=>$city]);
}

else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $playerID = isset($_POST["playerID"]) ? htmlspecialchars($_POST["playerID"]) : NULL;
    if( !nonEmpty($playerID) || !exists("player", $playerID) )
    {
	redirect(PATH_H."logout.php");
    }

    if($_POST["action"] == "photo")
    {
        if( !$_FILES["photo"]["size"] )
        {
	    apology(INPUT_ERROR, "Завантажте фото");
	    exit;
        }
        else
        {
            $photo = getPlayerName($playerID);
            $filepath = HOME_DIR . "public_html/img/player/" . $photo;

            if( !getimagesize($_FILES["photo"]["tmp_name"]) )
            {
                apology(INPUT_ERROR, "Завантажте фото");
                exit;
            }
            if( !move_uploaded_file($_FILES["photo"]["tmp_name"], $filepath) )
            {
                apology(INPUT_ERROR, "Помилка фотографії "." ".
		$filepath." ".$_FILES["photo"]["name"]);
                exit;
            }

	    $query = "UPDATE player P SET P.photo=? WHERE P.id=?";
	    query($query, $photo, $playerID);
	    sleep(1);
	    redirect("settings.php");
        }
    }
    else if($_POST["action"] == "pwd")
    {
   	$oldPwd = isset($_POST["oldPwd"]) ? htmlspecialchars($_POST["oldPwd"]) : NULL;
    	$newPwd1 = isset($_POST["newPwd1"]) ? htmlspecialchars($_POST["newPwd1"]) : NULL;
    	$newPwd2 = isset($_POST["newPwd2"]) ? htmlspecialchars($_POST["newPwd2"]) : NULL;
	if( !nonEmpty($oldPwd, $newPwd1, $newPwd2) )
        {
            apology(INPUT_ERROR, "Необхідно заповнити всі поля");
            exit;
	}

	$query = "SELECT U.hash FROM _user U WHERE U.login=?";
        $data = query($query, $login);

	if( !password_verify($oldPwd, $data[0][0]) )
	{
	    apology(INPUT_ERROR, "Введено неправильний попередній пароль");
	    exit;
        }

	if( $newPwd1 != $newPwd2 )
	{
	    apology(INPUT_ERROR, "Паролі не співпадають");
	    exit;
	}


	$newPassword = password_hash($newPwd1, PASSWORD_DEFAULT);
	$query = "UPDATE _user U SET U.hash=? WHERE U.login=?";
	query($query, $newPassword, $login);
	redirect(PATH_H."player/settings.php");
    }
    else if($_POST["action"] == "data")
    {
    	$fName = isset($_POST["fName"]) ? htmlspecialchars($_POST["fName"]) : NULL;
    	$lName = isset($_POST["lName"]) ? htmlspecialchars($_POST["lName"]) : NULL;
    	$city = isset($_POST["city"]) ? htmlspecialchars($_POST["city"]) : NULL;
    	$country = isset($_POST["country"]) ? htmlspecialchars($_POST["country"]) : NULL;
    	$birthday = isset($_POST["birthday"]) ? htmlspecialchars($_POST["birthday"]) : NULL;
	
	if( !nonEmpty($fName, $lName, $city, $country, $birthday) )
	    redirect("settings.php");

	updatePlayer($playerID, $fName, $lName, $city, $country, $birthday);

	redirect("settings.php");
    }
    else
	redirect(PATH_H."logout.php");
}


function updatePlayer($id, $new_fName, $new_lName, $new_city, $new_country, $new_birthday)
{
    list($fName, $lName, $img, $birthday, $country, $city)
         = getPlayer($id); 

    if( $new_fName != $fName || $new_lName != $lName )
    {
        $data = query("SELECT id FROM player WHERE firstName=? AND lastName=?", $new_fName, $new_lName);
	$new_id = isset($data[0][0]) ? $data[0][0] : NULL;
        if( nonEmpty($new_id) && $new_id != $id )
        {
            $msg = "Це ім'я та прізвище вже використовуються";
            adminApology(INPUT_ERROR, $msg);
            exit;
        }

        $query = "UPDATE player SET firstName=?, lastName=? WHERE id=?";
        query($query, $new_fName, $new_lName, $id);
    }

    if($new_city != $city || $new_country != $country || $new_birthday != $birthday )
    {
        $query = "UPDATE player SET city=?, country=?, birthday=? WHERE id=?";
        query($query, $new_city, $new_country, $new_birthday, $id);
    }

    redirect(PATH_H."player/settings.php");
}


function getPlayerName($id)
{
    $query = "SELECT P.firstName, P.lastName
	FROM player P WHERE P.id=?";
    $data = query($query, $id);
    $fName = $data[0][0]; $lName = $data[0][1];

    return $fName . "_" . $lName . ".jpg";
}


function getPlayer($id)
{
	$query="SELECT firstName,lastName,photo,birthday,
			country, city FROM player WHERE id=?";
	$data = query($query, $id);
	$birthday = date('Y-m-d', strtotime($data[0][3]));
	return array($data[0][0],$data[0][1],$data[0][2],$birthday,$data[0][4],$data[0][5]);
}

?>
