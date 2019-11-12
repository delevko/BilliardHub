<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/results.css">


<?php

    $query = "SELECT
    PT.playerID,
    CONCAT(P.lastName, ' ', P.firstName) AS player,
    PT.seed, TS.place, TS.points, P.photo
FROM playerTournament PT
    JOIN player P ON PT.playerID=P.id
    JOIN tournamentStandings TS ON PT.tournamentID=TS.tournamentID
                                AND PT.playerID=TS.playerID
WHERE PT.tournamentID=?";

    $data = query($query, $tournamentID);
	$data_count = count($data);   
 
	displayHeader();
	
	for($i = 0; $i < $data_count; $i++)
    {
		$playerID = $data[$i][0]; $player = $data[$i][1];
		$seed = $data[$i][2];
		$place = placeCast($data[$i][3]);

		$pts = $data[$i][4]; $img = $data[$i][5];
		$isLast = ($i+1==$data_count) ? true : false;
    	
		displayPlayer($i+1, $player, $playerID, $seed, $img, $place, $pts, $isLast);
	}

	displayFooter();

function displayPlayer($i, $name, $playerID, $seed, $plrPhoto, $place, $pts, $isLast)
{
	$e_o = ($i%2) ? "odd" : "even";
?>
            <tr class="tbody_<?=$e_o?>">
                <td class="bold <?=$e_o?>_num<?=($isLast)?" radius_bl":""?>">
                	<?=$seed?>
				</td>
                <td class="photo_name pointer"
				onclick="openPlayerLobby(<?=$playerID?>);">
                    <img class="circle_img" src="<?=PLAYER_IMG.$plrPhoto?>" alt="img">
                    <span><?=$name?></span>
                </td>
                <td>
                </td>
                <td>
					<?=$place?>
                </td>
                <td class="<?=($isLast)?" radius_br":""?>">
                	<?=$pts?>
				</td>
            </tr>
<?php }

function displayHeader()
{ ?>
    <div class="section_header">
        <div class="header_sign">
			Результати
		</div>
    </div>
    <div class="list_container">
    <table class="list_table results_table">
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
                <th>...</th>
                <th>
					<i class="fas fa-medal"></i>
					<span>Місце</span>
				</th>
                <th>
					<i class="fas fa-star"></i>
					<span>Очки</span>
				</th>
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

<?php }

function placeCast($place)
{
    if($place == "Last")
        return $place;
    else
        $place = ltrim($place, "Place ");

	if($place == "2-2")
		return "2";
	return $place;
}
?>

