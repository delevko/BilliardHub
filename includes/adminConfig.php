<?php

require("constants.php");
require("admin_user_functions.php");

session_start();

if(!adminCheck())
{
	redirect(PATH_H."logout.php");
}

require("functions.php");

?>
