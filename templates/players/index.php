
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/participants.css">


<?php 

	$data = query("SELECT P.id, P.firstName, P.lastName, P.photo,
				P.birthday, P.country, P.city FROM player P 
				WHERE P.id NOT IN(-1,-2) ORDER BY 2");
	$data_count = count($data);


	generalHeader();


	listHeader();

    for($i = 0; $i < $data_count; $i++)
    {
        $id = $data[$i][0]; $fName = $data[$i][1];
        $lName = $data[$i][2]; $img = $data[$i][3];
		$birthday = $data[$i][4];
		$country = $data[$i][5]; $city = $data[$i][6];
		$location = $city.", ".$country;

        printListPlayer($i+1, $id, $fName." ".$lName, $img, $birthday,$location, ($i+1==$data_count));
    }

    listFooter();


    barsHeader();

    for($i = 0; $i < $data_count; $i++)
    {
        $id = $data[$i][0]; $fName = $data[$i][1];
        $lName = $data[$i][2]; $img = $data[$i][3];
		
		$country = $data[$i][5]; $city = $data[$i][6];
		$location = $city.", ".$country;
        
		printBarsPlayer($id, $fName, $lName, $img, $location);
    }

    barsFooter();


	generalFooter();


function generalHeader()
{ ?>
	<script type="text/javascript" src="<?=PATH_H?>js/player_search.js"></script>
    <div class="sub-container">
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
<?php }
function generalFooter()
{ ?>
    </div>
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

function printListPlayer($i, $id, $name, $img, $birthday, $location, $isLast)
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
                <td class="<?=($isLast)?"radius_br":""?>">
                	<span><?=$location?></span>
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


function printBarsPlayer($id, $fName, $lName, $img, $location)
{ ?>
            <li class="pointer"
			onclick="openPlayerLobby(<?=$id?>);">
                <div class="players_list_item_box">
                    <figure>
                        <img class="players_list_item_photo" src="<?=PLAYER_IMG.$img?>" alt="фото гравця">
                    </figure>
                    <div class="players_list_item_details">
                        <div class="players_list_item_name">
                            <h4 class="players_list_item_name">
                                <?=$fName?> <span class="uppercase"><?=$lName?></span>
                            </h4>
                        </div>
                        <p class="players_list_item_location">
                            <?=$location?>
                        </p>
                    </div>
                </div>
            </li>
<?php
}
?>
