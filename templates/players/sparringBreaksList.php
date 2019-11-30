<?php

function sparringBreaksList($playerID)
{
    $query="SELECT
    B.points, B.matchID, B.playerID,
    CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    B.opponentID, CONCAT(O.lastName, ' ', O.firstName) AS opponentName,
    P.photo AS playerPhoto, O.photo AS opponentPhoto
FROM break B
    JOIN player P ON B.playerID = P.id
    JOIN player O ON B.opponentID = O.id
    JOIN _match M ON B.matchID = M.id
WHERE B.playerID=? AND B.tournamentID IS NULL
ORDER BY 1 DESC";


    $data = query($query, $playerID);
    $data_count = count($data);
  
    sparringBreaksHeader(); 

    for($i = 0; $i < $data_count; $i++)
    {
	$points = $data[$i][0]; $matchID = $data[$i][1];
	$plrID = $data[$i][2]; $plrName = $data[$i][3];
	$oppID = $data[$i][4]; $oppName = $data[$i][5];
	$plrPhoto = $data[$i][6]; $oppPhoto = $data[$i][7];

	$BL = ($i+1 == $data_count) ? "radius_bl" : "";
        $BR = ($i+1 == $data_count) ? "radius_br" : "";
	
	printSparringBreak($points,$i+1,$matchID,$plrName,$plrPhoto,$oppName,$oppPhoto,$BL,$BR);
    }

    sparringBreaksFooter();
}


function printSparringBreak($pts,$i,$mID,$plrName,$plrPhoto,$oppName,$oppPhoto,$BL,$BR)
{
    $e_o = ($i%2) ? "odd" : "even";
 ?>
            <tr class="tbody_<?=$e_o?> pointer"
	    onclick="openSparringLobby(<?=$mID?>);">
                <td class="<?=$BL?>">
                    <div class="photo_name">
                        <img class="circle_img" src="<?=PLAYER_IMG.$plrPhoto?>" alt="img">
                        <span><?=$plrName?></span>
                    </div>
                </td>
                <td class="bold <?=$e_o?>_num">
			<?=$pts?>
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

function sparringBreaksHeader()
{ ?>
	<div class="sub-container">
	<div class="section_header">
		<h3 class="header_sign">Брейки</h3>
	</div>
	<div class="list_container">
	<table class="list_table spar_breaks_table">
		<colgroup>
			<col class="col-1">
			<col class="col-2">
			<col class="col-3">
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
					<i class="fas fa-user-friends"></i>
					<span>Суперник</span>
				</th>
			</tr>
		</thead>
		<tbody>
<?php
}

function sparringBreaksFooter()
{ ?>
		</tbody>
	</table>
	</div>
	</div>
<?php
} ?>
