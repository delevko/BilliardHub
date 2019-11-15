<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/tournament_list.css"> 

<?php

generalHeader();

printList("Live");

printList("Registration");

printList("Standby");

printList("Announced");

printList("Finished");

generalFooter();




function printList($status)
{
	$query = "SELECT
    T.id AS tournamentID, T.name AS tournament,
    B.name AS billiard, A.name AS age, L.sex AS sex,
    C.name AS clubName,
    T.startDate, T.endDate, C.city, C.country
FROM tournament T
    JOIN league L ON T.leagueID = L.id
    JOIN age A ON L.ageID = A.id
    JOIN billiard B ON L.billiardID = B.id
    JOIN club C ON T.clubID = C.id
WHERE T.status=?";


	$data = query($query, $status);

	$data_count = count($data);
	
	listHeader( castTournamentHeader($status) );

	for($i=0; $i < $data_count; $i++)
	{
		$id = $data[$i][0]; $billiard = $data[$i][2];
		$age = $data[$i][3]; $sex = $data[$i][4];
		$clubName = $data[$i][5];
	
		$begDate = $data[$i][6]; $endDate = $data[$i][7];
		$date = dateFormat($begDate, $endDate);

		$name = $data[$i][1];
		$name .= " ($billiard) ";
		$name .= castDetails($age, $sex);

		$isLast = ($i+1==$data_count);

		$city = $data[$i][8]; $country = $data[$i][9];

		printTournament($i+1, $id, $name, $clubName, $date, $city.", ".$country, $isLast);
	}

	listFooter();
}

function printTournament($i, $id, $name, $clubName, $date, $place, $isLast)
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
					<?=$place?>
				</td>
				<td class="<?=($isLast)?"radius_br":""?>">
					<?=$date?>
				</td>
			</tr>
<?php
}

function generalHeader()
{ ?>
	<div class="sub-container">
		<div class="section_header">
			<div class="header_sign">
				<img class="header_icon" alt="calendar" src="<?=PATH_H?>img/web/calendar.png"> 
				Календар
			</div>
		</div>
<?php
}

function generalFooter()
{ ?>
	</div>
<?php
}

function listHeader($status)
{
?>
	<div class="section_header">
		<div class="header_sign">
			<?=$status?>
		</div>
	</div>

	<div class="list_container margin-b_30">
	<table class="list_table calendar_table">
		<colgroup>
			<col class="col-1">
			<col class="col-2">
			<col class="col-3">
			<col class="col-4">
			<col class="col-5">
		</colgroup>
		<thead>
			<tr>
				<th>#</th>
				<th>
					<i class="fas fa-trophy"></i>
					<span>Турнір</span>
				</th>
				<th>
					<i class="fas fa-shield-alt"></i>
					<span>Клуб</span>
				</th>
				<th>
					<i class="fas fa-map-marked-alt"></i>
					<span>Локація</span>
				</th>
				<th>
					<i class="far fa-calendar-alt"></i>
					<span>Дата</span>
				</th>
			</tr>
		</thead>
		<tbody>
<?php
}

function listFooter()
{
?>
		</tbody>	
	</table>
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
?>
