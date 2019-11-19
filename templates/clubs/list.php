
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/club_list.css">

<?php
displayClubs();

function displayClubs()
{
	$query =  "SELECT C.id, C.name, C.country, C.city, 
			C.nrOfTables, C.photo
			FROM club C ORDER BY 2";
	$data = query($query);
	$data_count = count($data);

	displayClubHeader();

	for($i = 0; $i < $data_count; $i++)
	{
		$id = $data[$i][0]; $name = $data[$i][1];
		$country = $data[$i][2]; $city = $data[$i][3];
		$tables = $data[$i][4]; $img = $data[$i][5];
		$BR = ($i+1 == $data_count) ? " radius_br" : "";
		$BL = ($i+1 == $data_count) ? " radius_bl" : "";

		displayClub($i+1,$id,$name,$city,$country,$tables,$img,$BR,$BL);
	}

	displayClubFooter();
}


function displayClub($i,$id,$name,$city,$country,$tables,$img,$BR,$BL)
{
	$e_o = ($i%2) ? "odd" : "even";
?>
			<tr class="tbody_<?=$e_o?> pointer"
			onclick="openClubLobby(<?=$id?>);">
				<td class="<?=$e_o?>_num<?=$BL?> bold">
					<?=$i?>
				</td>
				<td class="photo_name">
					<img src="<?=CLUB_IMG.$img?>" alt="club img" class="circle_img">
					<span><?=$name?></span>
				</td>
				<td>
					<?=$city?>, <?=$country?>
				</td>
				<td class="<?=$BR?>">
					<?=$tables?>
				</td>
			</tr>
<?php }


function displayClubHeader()
{ ?>
	<div class="sub-container">
		<div class="section_header_700">
			<i class="fas fa-shield-alt"></i>
			<div class="header_sign">клуби</div>
		</div>
		<div class="list_container">
		<table class="list_table_700 club_list_table">
			<colgroup>
				<col class="col-1">
				<col class="col-2">
				<col class="col-3">
				<col class="col-4">
			</colgroup>
			<thead>
				<th>#</th>
				<th>
					<i class="fas fa-shield-alt"></i>
					<span>клуб</span>
				</th>
				<th>
					<i class="fas fa-map-marked-alt"></i>
					<span>локація</span>
				</th>
				<th>
					столи
				</th>
			</thead>
			<tbody>
<?php }


function displayClubFooter()
{ ?>
			</tbody>
		</table>
		</div>
	</div>
<?php }

?>

