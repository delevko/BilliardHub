
<?php

function sparringList($playerID)
{
  $query = "SELECT M.id AS matchID,
    CONCAT(X.firstName, ' ', X.lastName) AS player1Name,
    CONCAT(Y.firstName, ' ', Y.lastName) AS player2Name,
    M.bestOF, M.player1Score, M.player2Score, MD.status,
    M.youtube
FROM _match M
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
    JOIN matchDetails MD ON M.id = MD.matchID
WHERE (X.id = ? OR Y.id = ?) AND M.tournamentID IS NULL
ORDER BY MD.status DESC, matchID DESC";


    $data = query($query, $playerID, $playerID);
    $data_count = count($data);

    sparringListHeader();

    for($i = 0; $i < $data_count; $i++)
    {
        $matchID = $data[$i][0];
        $player1 = $data[$i][1]; $player2 = $data[$i][2];
        $bestOf = $data[$i][3];
        $score1 = $data[$i][4]; $score2 = $data[$i][5];
        $status = $data[$i][6]; $youtube = $data[$i][7];

        $last = ($i+1 < $data_count) ? false : true;
        $live = ($status=="Live");

	displaySparring($i+1,$last,$matchID,$player1,$score1,$player2,$score2,$bestOf,$youtube,$live);
    }

    sparringListFooter();
}

function displaySparring($counter,$last,$mID,$player1,$score1,$player2,$score2,$bestOf,$link,$live)
{
        $e_o = ($counter%2) ? "odd" : "even";
?>
        <tr class="tbody_<?=$e_o?> pointer"
	onclick="openSparringLobby(<?=$mID?>);">
                <td class="bold <?=$e_o?>_num<?=($last)?" radius_bl":""?>">
                        <?=$counter?>
                </td>
                <td>
                <?php if ($live) { ?>
                        <span class="float_left live">live</span>
                <?php } ?>
                        <span class="float_right">
                                <?=$player1?>
                        </span>
                </td>
                <td>
                </td>
                <td>
                        <span class="font_20 bold float_right">
                                <?=$score1?>
                        </span>
                </td>
                <td>
                        <span>
                                (<?=$bestOf?>)
                        </span>
                </td>
                <td>
                        <span class="font_20 bold float_left">
                                <?=$score2?>
                        </span>
                </td>
                <td>
                </td>
                <td>
                        <span class="float_left">
                                <?=$player2?>
                        </span>
                </td>
                <td class="matches_list_table_youtube
                <?=$e_o?>_youtube
                <?=($last)?" radius_br":""?>"
                <?php if(nonEmpty($link)){ ?>
                        onclick="openYoutube(event,<?=("'".YT_HEADER.$link."'")?>);"
                <?php } ?>>
                        <?php if(nonEmpty($link)){ ?>
                                <i class="fab fa-youtube"></i>
                        <?php } ?>
                </td>
        </tr>
<?php }


function sparringListHeader()
{ ?>
    <div class="sub-container">
	<div class="section_header">
		<div class="header_sign">
			<span>
				Спаринги
			</span>
		</div>
	</div>
        <div class="list_container">
        <table class="list_table matches_list_table">
                <colgroup>
                        <col class="col-1">
                        <col class="col-2">
                        <col class="col-3">
                        <col class="col-4">
                        <col class="col-5">
                        <col class="col-6">
                        <col class="col-7">
                        <col class="col-8">
                        <col class="col-9">
                </colgroup>
                <thead>
                        <tr>
                                <th>#</th>
                                <th class="float_right">
                                        <i class="fas fa-user"></i>
                                        <span class="matches_list_nonres">
						Гравець 1
					</span>
                                        <span class="matches_list_res"> 1</span>
                                </th>
                                <th></th>
                                <th></th>
                                <th>v</th>
                                <th></th>
                                <th></th>
                                <th class="float_left">
                                        <i class="fas fa-user"></i>
                                        <span class="matches_list_nonres">
						Гравець 2
					</span>
                                        <span class="matches_list_res"> 2</span>
                                </th>
                                <th>
                                        <span>TV</span>
                                </th>
                        </tr>
                </thead>
                <tbody>
<?php }


function sparringListFooter()
{ ?>
		</tbody>
	</table>
	</div>
    </div>
<?php } ?>

