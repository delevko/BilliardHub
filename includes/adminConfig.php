<?php

require("functions.php");
require("constants.php");

session_start();

if(!adminCheck())
{
	redirect(PATH_H."logout.php");
}

?>
