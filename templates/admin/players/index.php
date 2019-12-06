<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/adm_participants.css"> 
    

<?php
function displayPlayers()
{
	plHeader();

	$query = "SELECT
    CONCAT(P.lastName, ' ', P.firstName) AS playerName,
    P.id AS playerID, P.photo AS photo,
    P.birthday AS birthday,
    P.city AS playerCity, P.country AS playerCountry
FROM player P
WHERE P.id != -1 AND P.id != -2 ORDER BY 1, 2";

    $data = query($query);
    $data_count = count($data);

    barsHeader();
    for($i = 0; $i < $data_count; $i++)
    {
	$player = $data[$i][0];
	$id = $data[$i][1]; $img = $data[$i][2];
	$birthday = date("d/m/Y", strtotime($data[$i][3]));

        $country = $data[$i][4]; $city = $data[$i][5];
        $location = $city.", ".$country;

        printBarsPlayer($id, $player, $img, $location, $birthday);
    }
    barsFooter();

    plFooter();
}


function plHeader()
{ ?>
	<script type="text/javascript" src="<?=PATH_H?>js/adm_player_search.js"></script>

	<div class="sub-container">
	<div class="section_header player_search">
		<div class="participants_header">
			<div class="header_sign">
				<i class="fas fa-users"></i>
				гравці
			</div>
			<div class="tab">
				<button>
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
function plFooter()
{ ?>
	</div>
	</div>
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
