
<?php

require("../../includes/config.php");

if( isset($_SESSION["id"] ) )
{
    if( !loginAvailable($_SESSION["id"]["login"]) )
    {
	$title = "Налаштування ".$_SESSION["id"]["login"];

	$name = ""; $photo = "";	

        render("player/settings.php", ["title"=>$title, "name"=>$name,
		"photo"=>$photo]);
    }
    else
	redirect(PATH_H."logout.php");
}
else
{
    redirect(PATH_H."logout.php");
}

?>
