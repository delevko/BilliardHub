<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/group_results.css"> 


<?php
	$query1 = "SELECT T.groupDone FROM tournament T WHERE T.id=?";
	$query2 = "SELECT EXISTS 
		(SELECT 1 FROM _match M
		JOIN matchDetails MD ON MD.matchID = M.id
		WHERE M.tournamentID=? AND M.roundType=? 
		AND MD.status != ?)";

	$groupDone = query($query1, $tournamentID);
	$matchesLeft = query($query2, $tournamentID, "Group", "Finished");
	
	if( !$groupDone[0][0] && !$matchesLeft[0][0] )
	{
		displayProceedButton($tournamentID);
	}


    $query = "SELECT
    CONCAT(P.lastName, ' ', P.firstName) AS player,
    GS.points, gs.seed, P.photo AS photo,
    GS.groupPlace, GS.groupNum, GS.playerID AS playerID
FROM groupStandings GS
    JOIN player P ON GS.playerID = P.id
    JOIN groupSeeding gs ON GS.tournamentID = gs.tournamentID
        AND GS.playerID = gs.playerID
WHERE GS.tournamentID=? ORDER BY 2 DESC, 5, 1";


    $data = query($query, $tournamentID);
	$data_count = count($data);

	displayHeader();
 
	for($i = 0; $i < $data_count; $i++)
    {
		$player = $data[$i][0]; $pts = $data[$i][1];
		$seed = $data[$i][2]; $photo = $data[$i][3];
		$grpPlace = $data[$i][4]; $grpNum = $data[$i][5];
		$playerID = $data[$i][6];
     	$isLast = ($i+1 == $data_count) ? true : false;
	
		displayPlayer($i+1, $playerID, $player, $seed, $photo, $grpPlace, $grpNum, $pts, $isLast); 
    }

	displayFooter();


function displayPlayer($i, $plrID, $name, $seed, $plrPhoto, $grpPlace, $grpNum, $pts, $isLast)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
            <tr class="tbody_<?=$e_o?>">
                <td class="bold <?=$e_o?>_num<?=($isLast)?" radius_bl":""?>">
                    <?=$seed?>
                </td>
                <td class="photo_name pointer"
				onclick="openPlayerLobby(<?=$plrID?>);">
                    <img class="circle_img" src="<?=PLAYER_IMG.$plrPhoto?>" alt="img">
                    <span><?=$name?></span>
                </td>
                <td>
					<?=$grpNum?>
                </td>
                <td>
                    <?=$grpPlace?>
                </td>
                <td class="<?=($isLast)?" radius_br":""?>">
                    <?=$pts?>%
                </td>
            </tr>
<?php }



function displayProceedButton($id)
{ ?>
	<form action="proceedGroup.php" method="post">
		<input type="hidden" name="id" value="<?=$id?>"/>
		<button type="submit" name="clicked" value="proceed">СІЯТИ ГРАВЦІВ</button>
	</form>
	<div id="divisor"><style>#divisor{height:20px}</style></div>

<?php }


function displayHeader()
{ ?>
    <div class="section_header">
        <div class="header_sign">
			Результати груп
		</div>
    </div>
    <div class="list_container">
    <table class="list_table group_results_table">
        <colgroup>
            <col class="col-1">
            <col class="col-2">
            <col class="col-3">
            <col class="col-4">
            <col class="col-5">
        </colgroup>
        <thead>
            <tr>
                <th>Жереб</th>
                <th>
					<i class="fas fa-user"></i>
					<span>Гравець</span>
				</th>
                <th>
					<i class="fas fa-users"></i>
					<span>Група</span>
				</th>
                <th>
					<i class="fas fa-medal"></i>
					<span>Місце в групі</span>
				</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
<?php
}

function displayFooter()
{ ?>
        </tbody>
    </table>
    </div>

<?php } ?>

