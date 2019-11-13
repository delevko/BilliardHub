<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	list($id, $bracket) = checkData($_POST["id"]);

	$minBreak = "";
	if( !nonEmpty($_POST["minBreak"]) )
		$minBreak = 20;
	else
		$minBreak = $_POST["minBreak"];

	list($LOW_R, $UP_R, $KO_R) = getDEData($id);

	$groups_P = ""; $lows_P = ""; $kos_P = "";
	$lows_P .= "$LOW_R:"; $kos_P .= ($KO_R+1).":";

	$lows_B .= "$LOW_R:"; $ups_B .= "$UP_R:";
	$kos_B .= "$KO_R:"; $groups_B = "";

	if($bracket == "GroupKO")
	{
    		list($grpMax, $grpProceed) = getGroupData($id);
		$groups_P .= ($grpMax-$grpProceed).":";
		
		for($i = $grpMax; $i > $grpProceed; $i--)
		{
			if( !nonEmpty($_POST["Group_R-$i"]) )
			{
				adminApology(INPUT_ERROR,
				"Введіть дані для всіх полів");
				exit;
			}
			$rnd_p = $_POST["Group_R-$i"];
			$groups_P .= "$rnd_p,";
		}
		if( !nonEmpty($_POST["Group_B"]) )
		{
			adminApology(INPUT_ERROR,
			"Введіть дані для всіх полів");
			exit;
		}
		$groups_B = $_POST["Group_B"];
	}


	for($i = 1; $i <= $LOW_R; $i++)
	{
		if( !nonEmpty($_POST["LOW_R-$i"]) ||
		!nonEmpty($_POST["LOW_B-$i"]) )
		{
			adminApology(INPUT_ERROR,
			"Введіть дані для всіх полів");
			exit;
		}
		$rnd_p = $_POST["LOW_R-$i"];
		$lows_P .= "$rnd_p,";

		$rnd_p = $_POST["LOW_B-$i"];
		$lows_B .= "$rnd_p,";
	}

	
        for($i = 1; $i <= $UP_R; $i++)
	{
		if( !nonEmpty($_POST["UP_B-$i"]) )
		{
			adminApology(INPUT_ERROR,
			"Введіть дані для всіх полів");
			exit;
		}
		$rnd_p = $_POST["UP_B-$i"];
		$ups_B .= "$rnd_p,";
	}


	for($i = 1; $i <= $KO_R; $i++)
	{
		if( !nonEmpty($_POST["KO_R-$i"]) ||
		!nonEmpty($_POST["KO_B-$i"]) )
		{
			adminApology(INPUT_ERROR,
			"Введіть дані для всіх полів");
			exit;
		}
		$rnd_p = $_POST["KO_R-$i"];
		$kos_P .= "$rnd_p,";

		$rnd_p = $_POST["KO_B-$i"];
		$kos_B .= "$rnd_p,";
	}

	$champ = $KO_R+1;
	if( !nonEmpty($_POST["KO_R-$champ"]) )
	{
		adminApology(INPUT_ERROR,
		"Введіть дані для всіх полів");
		exit;
	}
	$rnd_p = $_POST["KO_R-$champ"];
	$kos_P .= "$rnd_p,";


	$query = "CALL tournamentInput(?,?,?,?,?,?,?,?,?)";
	query($query, $id, $minBreak, $groups_P, $lows_P, $kos_P,
		$groups_B, $lows_B, $ups_B, $kos_B);

	redirect("../lobby.php?id=".$id."&onClick=default");
}
else
{
	redirect(PATH_H."logout.php");
}



function checkData($id)
{
	if( !nonEmpty($id) || !exists("tournament", $id) )
		redirect(PATH_H."logout.php");

	$query = "SELECT T.bracket FROM tournament T WHERE T.id=?";
	$data = query($query, $id);
	
	return array($id, $data[0][0]);
}


function getDEData($id)
{
    $query = "SELECT T.LOW_Rounds, T.UP_Rounds, T.KO_Rounds
        FROM tournament T WHERE T.id=?";
    $data = query($query, $id);

    $LOW_R = $data[0][0]; $UP_R = $data[0][1];
    $KO_R = $data[0][2];

    return array($LOW_R, $UP_R, $KO_R);
}


function getGroupData($id)
{
    $query = "SELECT T.groupMin, T.groupPlayers,
	T.nrOfGroups, T.groupProceed
        FROM tournament T WHERE T.id=?";
    $data = query($query, $id);

    $grpMin = $data[0][0]; $grpPlrs = $data[0][1];
    $n_grps = $data[0][2]; $grpProceed = $data[0][3];

    $grpMax = $grpMin + ceil( ($grpPlrs % $grpMin) / $n_grps );

    return array($grpMax,$grpProceed);
}
?>
