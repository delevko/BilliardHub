<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/participants.css"> 
    

<?php
	generalHeader();

	$query = "SELECT
    PT.seed, CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    PT.playerID AS playerID, P.photo AS photo,
    P.birthday AS birthday,
    P.city AS playerCity, P.country AS playerCountry
FROM playerTournament PT
    JOIN player P ON PT.playerID=P.id
WHERE PT.tournamentID=? ORDER BY 1, 2";

    $data = query($query, $tournamentID);
    $data_count = count($data);

    listHeader(); 
    for($i = 0; $i < $data_count; $i++)
    {
	$seed = $data[$i][0]; $player = $data[$i][1];
	$id = $data[$i][2]; $img = $data[$i][3];
	$birthday = date("d/m/Y", strtotime($data[$i][4]));

        $country = $data[$i][5]; $city = $data[$i][6];
        $location = $city.", ".$country;

        printListPlayer($i+1,$id,$player,$img,$birthday,$seed,$location,($i+1==$data_count));
    }
    listFooter();

    barsHeader();
    for($i = 0; $i < $data_count; $i++)
    {
	$seed = $data[$i][0]; $player = $data[$i][1];
	$id = $data[$i][2]; $img = $data[$i][3];
	$birthday = date("d/m/Y", strtotime($data[$i][4]));

        $country = $data[$i][5]; $city = $data[$i][6];
        $location = $city.", ".$country;

        printBarsPlayer($id, $player, $img, $location, $birthday);
    }
    barsFooter();

    generalFooter();


function generalHeader()
{ ?>
	<script type="text/javascript" src="<?=PATH_H?>js/player_search.js"></script>

	<div class="section_header player_search">
		<div class="participants_header">
			<div class="header_sign">
				<i class="fas fa-users"></i>
				гравці
			</div>
			<div class="tab">
				<button class="tablinks active"
				onclick="openTab(event, 'list')">
					<i class="fas fa-bars"></i>
				</button>
				<button class="tablinks"
				onclick="openTab(event, 'bars')">
					<i class="fas fa-th-large"></i>
				</button>
			</div>
		</div>
		<div class="players_list_search_field">
			<form class="centered_search_div" action="#">
				<input id="player_input" onkeyup="player_search()"
				type="text" placeholder="Пошук.." name="search">
			</form>
		</div>
	</div>
<?php
}
function generalFooter()
{ ?>
	</div>
<?php
}

function listHeader()
{ ?>
	<div id="list" class="sub-container tabcontent">
		<div class="list_container">
		<table id="table_list" class="list_table participants_table">
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
                        <i class="fas fa-user"></i>
                        <span>Гравець</span>
                    </th>
                    <th>
                        <i class="far fa-calendar-alt"></i>
                        <span>Дата народження</span>
                    </th>
                    <th>
                        <i class="fas fa-award"></i>
                        <span>Звання</span>
                    </th>
                    <th>
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Локація</span>
                    </th>
                    <th>Жереб</th>
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


function printListPlayer($i, $id, $name, $img, $birthday, $seed, $location, $isLast)
{
	$e_o = ($i%2) ? "odd" : "even";
 ?>
			<tr onclick="openPlayerLobby(<?=$id?>);"
				class="tbody_<?=$e_o?> pointer">
				<td class="bold <?=$e_o?>_num<?=($isLast)?" radius_bl":""?>">
					<?=$i?>
				</td>
				<td class="photo_name">
					<img class="circle_img" src="<?=PLAYER_IMG.$img?>" alt="img">
					<span><?=$name?></span>
				</td>
				<td>
					<span><?=$birthday?></span>
				</td>
				<td>
				</td>
				<td>
					<span><?=$location?></span>
				</td>
				<td class="<?=($isLast)?"radius_br":""?>">
					<span><?=$seed?></span>
				</td>
			</tr>
<?php
}


function barsHeader()
{ ?>
		<div id="bars" class="players_list_box tabcontent">
			<ul class="players_u-list_item" id="table_bars">
<?php
}

function barsFooter()
{ ?>
			</ul>
		</div>
<?php
}


function printBarsPlayer($id, $name, $img, $location, $birthday)
{ ?>
		<li onclick="openPlayerLobby(<?=$id?>);" class="pointer">
			<div class="players_list_item_box">
				<figure>
					<img class="players_list_item_photo" src="<?=PLAYER_IMG.$img?>" alt="img">
				</figure>


			    <div class="players_list_item_details">
				<div class="players_list_item_name">
				    <h4 class="players_list_item_name">
					<?=$name?>
				    </h4>
				</div>
				<div class="players_list_item_info">
				    <p class="players_list_item_location">
					<?=$location?>
				    </p>
				    <p class="players_list_item_bday">
					<?=$birthday?>
				    </p>
				</div>
			    </div>
		</li>
<?php
}

?>
