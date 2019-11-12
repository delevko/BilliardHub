<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST["id"];
	
	if( !exists("tournament", $id) )
	{
		redirect("../");
	}

	$query = "UPDATE tournament SET status=? WHERE id=?";
	query($query, "Registration", $id);

	redirect("../lobby.php?id=$id");
}
else
{
	redirect(PATH_H."logout.php");
}
?>
