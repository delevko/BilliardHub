
<?php

require("../../includes/userConfig.php");
$login = $_SESSION["id"]["login"];

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$title = "Налаштування $login";

	$query = "SELECT
	CONCAT(P.firstName, ' ', P.lastName) AS name, P.photo,
	P.id
	FROM player P JOIN _user U ON P.id=U.playerID
	WHERE U.login=?";
	$data = query($query, $login);

	$name = $data[0][0]; $photo = $data[0][1];
	$playerID = $data[0][2];

	render("player/settings.php",
	["title"=>$title, "name"=>$name,
	"photo"=>$photo, "playerID"=>$playerID]);
}


else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if( !nonEmpty($_POST["playerID"]) ||
	!exists("player", $_POST["playerID"]))
    {
	redirect(PATH_H."logout.php");
    }
    $playerID = $_POST["playerID"];


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
	if( !nonEmpty($_POST["oldPwd"],
	$_POST["newPwd1"], $_POST["newPwd2"]) )
        {
            apology(INPUT_ERROR, "Необхідно заповнити всі поля");
            exit;
	}
	$oldPwd = $_POST["oldPwd"]; $newPwd1 = $_POST["newPwd1"];
	$newPwd2 = $_POST["newPwd2"];


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
    else
	redirect(PATH_H."logout.php");
}



function getPlayerName($id)
{
    $query = "SELECT P.firstName, P.lastName
	FROM player P WHERE P.id=?";
    $data = query($query, $id);
    $fName = $data[0][0]; $lName = $data[0][1];

    return $fName . "_" . $lName . ".jpg";
}

?>
