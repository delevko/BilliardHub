<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	list($seeding,$seeded,$id) = checkData1($_POST["seeding"],$_POST["playersSeeded"],$_POST["id"]);
	list($groupMin,$proceed) = checkData2($_POST["groupMin"], $_POST["proceed"]);
	
	list($registered, $groupPlayers, $nrOfGroups, $N, $add_R, $seeded_R, $KO_R)
	= getData($id,$proceed,$groupMin,$seeded);
	

	$query = "CALL GroupKnockoutGenerate(?,?,?,?,?,?,?,?,?,?)";
	query($query,$id,$groupMin,$proceed,$groupPlayers,$N,$seeded,$KO_R,$seeded_R,$add_R,$seeding);
	
	if($seeded !== 0)
	{
		seedKO($id, $seeded, $seeded_R);
	}

	seedPlayers($id, $nrOfGroups, $groupPlayers, $groupMin);

	query("CALL groupMatchesGenerate(?,?)", $id, $nrOfGroups);
	
	redirect("../lobby.php?id=$id");
}
else
{
	redirect("../");
}

function seedKO($id, $seeded, $seeded_R)
{
	$seed_arr = getSeedingArrayMy(LOG($seeded*2, 2), 1, $seeded*2);
	$match_counter = ($seeded_R-1)*$seeded + 1;

	for($i = 0; $i < $seeded; $i++)
	{
		$playerSeed = $seed_arr[$i*2];
		query("CALL seedPlayer(?,?,?,?)", $id, $match_counter, "K/O", $playerSeed);
		$match_counter++;
	}
}

function seedPlayers($id, $nrOfGroups, $groupPlayers, $groupMin)
{
	$seed_arr = array();
	for($k=1; $k<=$nrOfGroups; $k++)
		array_push($seed_arr, $k);

	$count = 0; $player = 0;
	while( $count < $groupPlayers )
	{
		$player++;
		shuffle($seed_arr);
		for($i = 1; $i <= $nrOfGroups; $i++)
		{
			$seed = $seed_arr[$i-1] + ($player-1)*$nrOfGroups;
			query("CALL seedPlayerGroup(?,?,?,?)", $id, $i, $seed, $player);
		}
		$count += $nrOfGroups;
	}
}

function getPlayers($id)
{
    $data = query("SELECT registeredPlayers FROM tournament WHERE id = ?", $id);
    return $data[0][0];
}

function checkData1($seeding, $seeded, $id)
{
    if( !nonEmpty($seeding, $id) )
        redirect("../");
    if( !exists("tournament", $id) )
        redirect("../");
    if( !nonEmpty($seeded) )
        $seeded = 0;

    return array($seeding, $seeded, $id);
}

function checkData2($groupMin, $proceed)
{
	if( !nonEmpty($groupMin) )
	{
		adminApology(INPUT_ERROR, "\"Min in a single group\" required for GROUPS-KNOCKOUT");
		exit;
	}
	if( !nonEmpty($proceed) )
	{
		$proceed = ceil($groupMin/2);
	}

	return array($groupMin, $proceed);
}

function getData($id, $proceed, $groupMin, $seeded)
{
	$registered = getPlayers($id);
	if( $seeded > $registered )
    {
        adminApology(INPUT_ERROR, "Seeded number cannot exceed registered players");
        exit;
    }

	$groupPlayers = $registered - $seeded;
	$nrOfGroups = FLOOR($groupPlayers/$groupMin);
	$totalGroupProceed = $nrOfGroups * $proceed;
	
	if($seeded === 0)
	{
		$N = firstGreaterPowerOf2($totalGroupProceed);
		$add_R = 0;
		$seeded_R = 1;
		$KO_R = LOG($N, 2);
	}
	else
	{
		$N = $seeded*2;
		$add_R = FLOOR( ($totalGroupProceed-1)/$seeded);
		$seeded_R = $add_R + 1;
		$KO_R = $add_R + LOG($N, 2);
	}

	return array($registered, $groupPlayers, $nrOfGroups, $N, $add_R, $seeded_R, $KO_R);
}
?>
