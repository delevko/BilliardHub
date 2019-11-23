<?php

function sparringBreaksList($playerID)
{
    $query="SELECT
    B.points, B.matchID, B.playerID,
    CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    B.opponentID, CONCAT(O.lastName, ' ', O.firstName) AS opponentName,
    P.photo AS playerPhoto, O.photo AS opponentPhoto,
    T.name AS tournamentName, M.roundType, T.id
FROM break B
    JOIN player P ON B.playerID = P.id
    JOIN player O ON B.opponentID = O.id
    JOIN _match M ON B.matchID = M.id
    JOIN tournament T ON B.tournamentID = T.id
WHERE B.playerID=? ORDER BY 1 DESC";


    $data = query($query, $playerID);
	$data_count = count($data);
  
	_printHeader(); 

	for($i = 0; $i < $data_count; $i++)
	{
		$points = $data[$i][0]; $matchID = $data[$i][1];
		$plrID = $data[$i][2]; $plrName = $data[$i][3];
		$oppID = $data[$i][4]; $oppName = $data[$i][5];
		$plrPhoto = $data[$i][6]; $oppPhoto = $data[$i][7];
		$trnName = $data[$i][8]; $trnID = $data[$i][10];
		$rndType = $data[$i][9];
	
                list($rndNo, $KO_R, $seeded_R) =
                        _getGeneralDetails($matchID, $rndType);

                $round = castBreakHeader($rndType,$rndNo,$KO_R,$seeded_R);

		$BL = ($i+1 == $data_count) ? "radius_bl" : "";
        $BR = ($i+1 == $data_count) ? "radius_br" : "";
	
		printSparringBreak($points, $i+1, $matchID, $plrName, $plrPhoto, $oppName, $oppPhoto, $BL, $BR, $trnName, $round, $trnID);
	}

	_printFooter();
}


function _getGeneralDetails($id, $rType)
{
    $grpORround = ($rType=="Group") ? "GT.groupNum" : "M.roundNo";
    $query = "SELECT ".$grpORround.", T.KO_Rounds, T.seeded_Round
   FROM _match M JOIN tournament T ON M.tournamentID=T.id
   LEFT JOIN groupTournament GT ON M.groupID = GT.id
   WHERE M.id=?";
    $data = query($query, $id);

    return array($data[0][0], $data[0][1], $data[0][2]);
}



function printSparringBreak($pts,$i,$mID,$plrName,$plrPhoto,$oppName,$oppPhoto,$BL,$BR,$trnName,$round,$tID)
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
                <td>
					<?=$trnName?>
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

function _printHeader()
{ ?>
	<div class="sub-container">
	<div class="section_header">
		<h3 class="header_sign">Брейки</h3>
	</div>
	<div class="list_container">
	<table class="list_table breaks_table">
		<colgroup>
			<col class="col-1">
			<col class="col-2">
			<col class="col-3">
			<col class="col-4">
			<col class="col-5">
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
					<i class="fas fa-trophy"></i>
					<span>Турнір</span>
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

function _printFooter()
{ ?>
		</tbody>
	</table>
	</div>
	</div>
<?php
} ?>
