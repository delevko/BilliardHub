<?php

require("../../includes/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $tournamentID = $_GET["id"];
	if( !exists("tournament", $tournamentID) )
		redirect("");

	$onClick = "";
	if( nonEmpty($_GET["onClick"]) )
		$onClick = $_GET["onClick"];
	else
		$onClick = "default";
	
	lobbyGenerate($tournamentID, $onClick);
}
else
{
	redirect("");
}


function lobbyGenerate($tournamentID, $onClick)
{
	$query = "SELECT T.name, T.status
		FROM tournament T WHERE T.id=?";
	$data = query($query, $tournamentID);

	$tournamentName = $data[0][0];
	$status = $data[0][1];

	if( $onClick == "default" )
	{
		if( $status == "Announced" || $status == "Standby"
		|| $status == "Registration" )
		{
			redirect("lobby.php?id=".$tournamentID.
				"&onClick=participants");
		}
		else if( $status == "Live" )
		{
			redirect("lobby.php?id=".$tournamentID.
				"&onClick=bracket");
		}
		else if( $status == "Finished" )
		{
			redirect("lobby.php?id=".$tournamentID.
				"&onClick=standings");
		}
	}


	render("tournaments/lobby.php", ["title"=>$tournamentName, 
		"tournamentName"=>$tournamentName, "tournamentID"=>$tournamentID, "status"=>$status, "onClick"=>$onClick]);

}
?>
