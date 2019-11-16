<?php

function tournamentList($playerID)
{
	$query = "SELECT
    T.name AS tournamentName, PT.tournamentID,
    C.name AS clubName, TS.place, TS.points,
    T.startDate, T.endDate
FROM playerTournament PT
    JOIN tournament T ON PT.tournamentID=T.id
    JOIN club C ON T.clubID=C.id
    LEFT JOIN tournamentStandings TS ON PT.playerID = TS.playerID
                            AND T.id = TS.tournamentID
WHERE PT.playerID=? AND TS.place IS NOT NULL
ORDER BY 5 DESC, 4";


	$data = query($query, $playerID);
	$data_count = count($data);
	

	listHeader();

    for($i = 0; $i < $data_count; $i++)
    {
        $name = $data[$i][0]; $id = $data[$i][1];
		$clubName = $data[$i][2]; $isLast = ($i+1==$data_count);

		$place = placeCast($data[$i][3]);
		$pts = $data[$i][4]; 

		$begDate = $data[$i][5]; $endDate = $data[$i][6];
        	$date = dateFormat($begDate, $endDate);

	 	displayTournament($i+1,$id,$name,$clubName,$date,$isLast,$place,$pts);
	}

	listFooter();
}


function displayTournament($i, $id, $name, $clubName, $date, $isLast, $place,$pts)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
            <tr onclick="openTournamentLobby(<?=$id?>);"
            class="tbody_<?=$e_o?> pointer">
                <td class="bold <?=$e_o?>_num<?=($isLast)?" radius_bl":""?>">
                    <?=$i?>
                </td>
                <td>
                    <?=$name?>
                </td>
                <td>
                    <?=$clubName?>
                </td>
                <td>
                    <?=$date?>
                </td>
                <td>
                    <?=$place?>
                </td>
                <td class="<?=($isLast)?"radius_br":""?>">
                    <?=$pts?>
                </td>
            </tr>
<?php
}


function listHeader()
{ ?>
    <div class="sub-container">
        <div class="section_header">
            <div class="header_sign">
				Турніри
			</div>
        </div>
		<div class="list_container">
		<table class="list_table player_tournaments_table">
			<colgroup>
				<col class="col-1">
				<col class="col-2">
				<col class="col-3">
				<col class="col-4">
				<col class="col-5">
				<col class="col-6">
			</colgroup>
			<thead>
				<tr>
					<th>#</th>
					<th>
						<i class="fas fa-trophy"></i>
						<span>Турнір</span>
					</th>
					<th>
						<i class="fas fa-map-marked-alt"></i>
						<span>Клуб</span>
					</th>
					<th>
						<i class="far fa-calendar-alt"></i>
						<span>Дата</span>
					</th>
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
function listFooter()
{ ?>
			</tbody>
		</table>
		</div>
    </div>
<?php
}

function dateFormat($beg, $end)
{
    $beg = date("d/m/Y", strtotime($beg));
    $end = date("d/m/Y", strtotime($end));
    if($beg == $end)
    {
        return $beg;
    }
    else
    {
        return $beg." - ".$end;
    }
}

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

