<?php

require("../../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	list($id) = checkData($_POST["id"]);

//	list($N, $registered, $add_R, $seeded_R, $KO_R) = getData($seeded, $id);

//	$query = "CALL KnockoutGenerate(?,?,?,?,?,?,?,?)";
//	query($query, $id, $seeded, $KO_R, $add_R, $seeded_R, $N, $seeding, $registered);

//	seedPlayers($id, $N/2, $seeded_R);

	$query = "CALL startTournament(?)";
	query($query, $id);

	redirect("../lobby.php?id=".$id."&onClick=default");
}
else
{
	redirect(PATH_H."logout.php");
}


function seedPlayers($id, $seeded, $seeded_R)
{
	if($seeded_R > 1)
		$seed_array = getSeedingArrayMy(LOG($seeded*2, 2), 1, $seeded*2);
	else
		$seed_array = getSeedingArray(LOG($seeded*2, 2), 1, $seeded*2);

	$flag = 0;
	for($i = $seeded_R; $i >= 1; $i--)
	{
		$match_counter = ($i-1)*$seeded + 1;
		for($j = 0; $j < $seeded; $j++)
		{
			$playerSeed = $seed_array[$j*2+$flag] + ($seeded_R-$i-$flag)*$seeded;
			query("CALL seedPlayer(?,?,?,?)", $id, $match_counter, "K/O", $playerSeed);
			$match_counter++;
		}
		if($flag === 0)
			$flag = 1;
		else 
			$flag = 0;
	}

	$match_counter = 1;
	for($j = 0; $j < $seeded; $j++)
	{
		$playerSeed = $seed_array[$j*2+$flag] + ($seeded_R-$flag)*$seeded;
		query("CALL seedPlayer(?,?,?,?)", $id, $match_counter, "K/O", $playerSeed);
		$match_counter++;
	}
}


function checkData($id)
{
	if( !nonEmpty($id) || !exists("tournament", $id) )
		redirect(PATH_H."logout.php");
	
	return array($id);
}

function getPlayers($id)
{
	$data = query("SELECT registeredPlayers FROM tournament WHERE id = ?", $id);
	return $data[0][0];
}

function getData($seeded, $id)
{
	$registered = getPlayers($id);
	
	if( $seeded > $registered )
	{
		adminApology(INPUT_ERROR, "Кількість сіяних гравців не може перевищувати кількість учасників турніру");
		exit;
	}
	
	if( $seeded === 0 )
	{	
		$N = firstGreaterPowerOf2($registered);
		$add_R = 0;
		$seeded_R = 1;
		$KO_R = LOG($N, 2);
	}
	else
	{
		$N = $seeded*2;
		$registered -= $seeded;
		$add_R = FLOOR( ($registered-1)/$seeded );
		$seeded_R = $add_R + 1;
		$KO_R = $add_R + LOG($N, 2);
	}

	return array($N, $registered, $add_R, $seeded_R, $KO_R);
}
?>
