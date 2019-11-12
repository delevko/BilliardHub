<?php

require("../../../includes/adminConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$id = checkData1($_POST["clicked"], $_POST["id"]);
	
	list($N, $totalGroupProceed, $seeded_R, $seeded) = getData($id);

	if( $seeded_R == 1 && $seeded == 0 )	
		$seed_array = getSeedingArray(LOG($N, 2), 1, $N);
	else
		$seed_array = getSeedingArrayMy(LOG($N, 2), 1, $N);
	
	$query = "CALL seedPlayer(?,?,?,?)";

	if($seeded_R === 1 && $seeded > 0)
	{
		for($i=0; $i < $N/2; $i++)
			query($query, $id, $i+1, "K/O", $seed_array[$i*2+1]);
	}
	else
	{
		$flag = true;
		for($i = $seeded_R-1; $i > 1; $i--)
		{
			$match_counter = ($i-1)*$seeded + 1;
			for($j = 0; $j < $seeded; $j++)
			{
				$playerSeed = $seed_array[$j*2+(int)$flag] + ($seeded_R-$i-(int)$flag)*$seeded;
				query($query, $id, $match_counter, "K/O", $playerSeed);
				$match_counter++;
			}
			$flag = !$flag;
		}
	
		
		if($seeded_R === 1)
			list($flag1, $flag2, $offset1, $offset2) = array(0,1,0,0);
		else
			list($flag1, $flag2, $offset1, $offset2) = 
			getFlagsAndOffsets($flag, $seeded_R, $seeded);
	
	// only first round left
		for($i=0; $i < $N/2; $i++)
		{
		//add groupChecking
			$seed1 = $seed_array[$i*2+$flag1] + $offset1;
			query($query, $id, $i+1, "K/O", $seed1);
			
			$seed2 = $seed_array[$i*2+$flag2] + $offset2; 
			query($query, $id, $i+1, "K/O", $seed2);
		}
	}
	
	redirect("lobby.php?id=$id");
}
else
{
	redirect("../");
}


function getFlagsAndOffsets($flag, $seeded_R, $seeded)
{
	if( !$flag )
	{
		$offset = ($seeded_R-1) * $seeded;
		return array(0, 1, $offset, $offset);
	}
	else
	{
		$offset1 = ($seeded_R-2)*$seeded;
		$offset2 = ($seeded_R)*$seeded;
		return array(1, 0, $offset1, $offset2);
	}
}


function checkData1($clicked, $id)
{
    if( !nonEmpty($id, $clicked) )
        redirect("../");
    if( !exists("tournament", $id) )
        redirect("../");
    if( strcmp($clicked, "proceed") )
        redirect("../");

	$flag = query("SELECT T.groupDone FROM tournament T WHERE T.id=?", $id);
    if( $flag[0][0] )
        redirect("../");

// TODO maybe put at the end
	query("UPDATE tournament T SET T.groupDone=TRUE WHERE T.id=?", $id);
    return $id;
}


function getData($id)
{
	$query = "SELECT T.seededPlayers, T.seeded_Round, T.totalGroupProceed
		FROM tournament T WHERE T.id=?";
	$data = query($query, $id);	

	$seeded = $data[0][0];
	$seeded_R = $data[0][1];
	$totalGroupProceed = $data[0][2];

	if($seeded === 0)
		$N = firstGreaterPowerOf2($totalGroupProceed);	
	else
		$N = $seeded*2;

	return array($N, $totalGroupProceed, $seeded_R, $seeded);
}

?>
