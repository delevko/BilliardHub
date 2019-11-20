<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/participants_short.css">

<?php
    $query = "SELECT
        CONCAT(P.lastName, ' ', P.firstName) AS playerName,
        P.photo AS photo
FROM playerTournament PT
    JOIN player P ON PT.playerID=P.id
WHERE PT.tournamentID=? ORDER BY 1";

    $data = query($query, $tournamentID);
	$data_count = count($data);

	printHeader();

    for($i = 0; $i < $data_count; $i++)
    {
		$player = $data[$i][0]; $photo = $data[$i][1];

		$BL = ($i+1 == $data_count) ? " radius_bl" : "";
		$BR = ($i+1 == $data_count) ? " radius_br" : "";

		displayPlayer($i+1, $player, $photo, $BL, $BR);
    }

	printFooter();


function displayPlayer($i, $name, $photo, $BL, $BR)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
            <tr class="tbody_<?=$e_o?>">
                <td class="bold <?=$e_o?>_num<?=$BL?>">
					<?=$i?>
				</td>
                <td class="<?=$BR?>">
			<div class="photo_name">
				<img class="circle_img" src="<?=PLAYER_IMG.$photo?>"
				alt="img">
				<span><?=$name?></span>
                	</div>
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
    <table class="list_table_700 participants_short_table">
        <colgroup>
            <col class="col-1">
            <col class="col-2">
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

