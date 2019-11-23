<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/tournament_breaks.css"> 


<?php


    $data = query("SELECT minBreak FROM tournament WHERE id=?", $tournamentID);
    printHeader($data[0][0]); 

    $query = "SELECT
    B.points, B.matchID, B.playerID,
    CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    B.opponentID, CONCAT(O.lastName, ' ', O.firstName) AS opponentName,
    P.photo AS playerPhoto, O.photo AS opponentPhoto,
    M.roundType
FROM break B
    JOIN player P ON B.playerID = P.id
    JOIN player O ON B.opponentID = O.id
    JOIN _match M ON B.matchID = M.id
WHERE M.tournamentID=? ORDER BY 1 DESC, 4";

    $data = query($query, $tournamentID);
	$data_count = count($data);

	for($i = 0; $i < $data_count; $i++)
	{
		$points = $data[$i][0]; $matchID = $data[$i][1];
		$plrID = $data[$i][2]; $plrName = $data[$i][3];
		$oppID = $data[$i][4]; $oppName = $data[$i][5];
		$plrPhoto = $data[$i][6]; $oppPhoto = $data[$i][7];
		$rndType = $data[$i][8];

		list($rndNo, $KO_R, $seeded_R) =
			getGeneralDetails($matchID, $rndType);

		$round = castBreakHeader($rndType,$rndNo,$KO_R,$seeded_R);

		$BL = ($i+1 == $data_count) ? "radius_bl" : "";
		$BR = ($i+1 == $data_count) ? "radius_br" : "";
	
		printBreak($points, $i+1, $matchID, $plrName, $plrPhoto, $oppName, $oppPhoto, $BL,$BR, $round, $tournamentID);
	}

	printFooter();



function getGeneralDetails($id, $rType)
{
    $grpORround = ($rType=="Group") ? "GT.groupNum" : "M.roundNo";
    $query = "SELECT ".$grpORround.", T.KO_Rounds, T.seeded_Round
   FROM _match M JOIN tournament T ON M.tournamentID=T.id
   LEFT JOIN groupTournament GT ON M.groupID = GT.id
   WHERE M.id=?";
    $data = query($query, $id);

    return array($data[0][0], $data[0][1], $data[0][2]);
}



function printBreak($pts,$i,$mID,$plrName,$plrPhoto,$oppName,$oppPhoto,$BL,$BR, $round, $tID)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
            <tr onclick="openMatchLobby(<?=$tID?>,<?=$mID?>);"
            class="tbody_<?=$e_o?> pointer">
				<td class="<?=$BL?>">
					<div class="photo_name">
						<img class="circle_img" src="<?=PLAYER_IMG.$plrPhoto?>" alt="img">
						<span><?=$plrName?></span>
                	</div>
				</td>
                <td class="bold <?=$e_o?>_num">
					<?=$pts?>
				</td>
                <td class="uppercase">
				<span>
					<?=$round?>
				</span>
                </td>
				<td class="<?=$BR?>">
					<div class="photo_name">
						<img class="circle_img" src="<?=PLAYER_IMG.$oppPhoto?>" alt="img">
						<span><?=$oppName?></span>
                	</div>
				</td>
            </tr>
<?php
}

function printHeader($minBreak)
{ ?>
	<div class="section_header">
		<div class="header_sign">
			Брейки (<?=$minBreak?>+)
		</div>
	</div>
	<div class="list_container">
	<table class="list_table breaks_table">
		<colgroup>
			<col class="col-1">
			<col class="col-2">
			<col class="col-3">
			<col class="col-4">
		</colgroup>
		<thead>
			<tr>
                <th>
                    <i class="fas fa-user"></i>
                    <span>Гравець</span>
                </th>
                <th>
                    <i class="fas fa-star"></i>
                    <span>Очки</span>
                </th>
                <th>
					<i class="fas fa-clipboard"></i>
                    <span>Раунд</span>
                </th>
                <th>
                    <i class="fas fa-user-friends"></i>
                    <span>Суперник</span>
                </th>
            </tr>
		</thead>
		<tbody>
<?php
}

function printFooter()
{ ?>
		</tbody>
	</table>
	</div>

<?php
} ?>
