<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST["id"];
	
	if( !nonEmpty($id) || !exists("tournament", $id) )
	{
		redirect(PATH_H."logout.php");
	}

	$query = "UPDATE tournament SET status=? WHERE id=?";
	query($query, "Registration", $id);

	redirect("../lobby.php?id=".$id."&onClick=participants");
}
else
{
	redirect(PATH_H."logout.php");
}
?>
