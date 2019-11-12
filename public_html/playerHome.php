<?php

require("../includes/config.php");

if(!isset($_SESSION["id"]))
{
	redirect("logout.php");
}

$title = "HomePage";
$username = $_SESSION["id"]["login"];

require("../templates/default/header.php");
require("../templates/player/landing.php");
require("../templates/player/playerFooter.php");

?>
