<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/participants_seed.css">

<?php
    $query = "SELECT
        CONCAT(P.lastName, ' ', P.firstName) AS playerName,
        P.photo AS photo, P.id AS playerID, PT.seed
FROM playerTournament PT
    JOIN player P ON PT.playerID=P.id
WHERE PT.tournamentID=? ORDER BY 1";

    $data = query($query, $tournamentID);
    $data_count = count($data);

    printHeader();

    for($i = 0; $i < $data_count; $i++)
    {
	$player = $data[$i][0]; $photo = $data[$i][1];
	$id = $data[$i][2]; $seed = $data[$i][3];

	$BL = ($i+1 == $data_count) ? " radius_bl" : "";
	$BR = ($i+1 == $data_count) ? " radius_br" : "";

	displayPlayer($i+1, $player, $id, $seed, $photo);
    }

    lastRow($data_count+1, $tournamentID, $data_count);

    printFooter();


function displayPlayer($i, $name, $id, $seed, $photo)
{
    $e_o = ($i%2) ? "odd" : "even";
    $seed_e_o = !($i%2) ? "odd" : "even";
?>
	    <tr class="tbody_<?=$e_o?>">
                <td class="bold <?=$e_o?>_num">
			<?=$i?>
		</td>
		<td>
			<div class="photo_name">
				<img class="circle_img" src="<?=PLAYER_IMG.$photo?>"
				alt="img">
				<span><?=$name?></span>
                	</div>
		</td>
                <td class="">
			<input class="seed_input tbody_<?=$seed_e_o?>" type="number"
			name="<?=$id?>" value="<?=$seed?>">
		</td>
            </tr>
<?php
}


function lastRow($i, $tournamentID, $n_players)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
	    <input type="hidden" name="tournamentID" value="<?=$tournamentID?>">
	    <tr class="tbody_<?=$e_o?>">
                <td class="<?=$e_o?>_num radius_bl">
		</td>
		<td>
		</td>
                <td class="radius_br">
			<button type="submit" class="tbody_<?=$e_o?>"> <i class="fas fa-check pointer"></i> </button>
		</td>
            </tr>
<?php
}

function printHeader()
{ ?>
    <div class="section_header_700">
        <div class="header_sign">Гравці</div>
    </div>
    <div class="list_container">
    <table class="list_table_700 participants_seed_table">
        <colgroup>
            <col class="col-1">
            <col class="col-2">
            <col class="col-3">
        </colgroup>
        <thead>
            <tr>
		<th>
			#
		</th>
		<th>
                    <i class="fas fa-user"></i>
                    <span>Гравець</span>
                </th>
		<th>
		    Жереб
		</th>
            </tr>
        </thead>
        <tbody>
		<form method="post" action="<?=PATH_H?>admin/tournaments/start/seeding.php">
<?php
}

function printFooter()
{ ?>
		</form>
        </tbody>
    </table>
    </div>

<?php
} ?>

