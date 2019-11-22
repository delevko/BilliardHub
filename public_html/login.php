<?php

require("../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    render("loginForm.php", ["title" => "Вхід"]);
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if( !nonEmpty($_POST["username"],$_POST["password"]) )
    {
        apology(INPUT_ERROR, "Введіть логін ТА пароль");
        exit;
    }   
        
    $query = "SELECT hash, login, userType FROM _user WHERE login=?";
    $login = $_POST["username"];

    $data = query($query, $login);

    if(count($data) > 0 && password_verify($_POST["password"], $data[0][0]))
    {
	$login = $data[0][1]; $type = $data[0][2];
        $_SESSION["id"] = ["login"=>$login, "type"=>$type];

	redirect("index.php");
    }

    apology(INPUT_ERROR, "Неправильне ім'я користувача АБО пароль");
}

?>
