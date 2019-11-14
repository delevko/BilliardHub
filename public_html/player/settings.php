
<?php

require("../../includes/config.php");

if( isset($_SESSION["id"] ) )
{
    if( !loginAvailable($_SESSION["id"]["login"]) )
    {
	$title = "Налаштування ".$_SESSION["id"]["login"];


        render("player/settings.php", ["title"=>$title]);
    }
    else
	redirect(PATH_H."logout.php");
}
else
{
    redirect(PATH_H."logout.php");
}

?>
