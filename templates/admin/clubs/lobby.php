<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/available_tables.css">
</br></br>


<?php
	$query = "SELECT
    T.id AS tournamentID, T.name AS tournament
FROM tournament T
    JOIN club C ON T.clubID = C.id
WHERE C.id=? AND T.status=?
";

	$data = query($query, $clubID, "Live");
	$data_count = count($data);

	if($data_count > 0)
	{
		buttonHeader($clubID);

		for($i=0; $i < $data_count; $i++)
		{
			$id = $data[$i][0]; $name = $data[$i][1];
			displayTournament($id, $name);
		}

		buttonFooter();
	}


	$query = "SELECT
    tbl.id AS tableID, tbl._number, tbl.status AS tableStatus,
    CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    X.photo AS photo1, Y.photo AS photo2,
    M.player1Score, M.player2Score, M.bestOf
FROM _table tbl
    LEFT JOIN _match M ON tbl.matchID = M.id
    LEFT JOIN player X ON M.player1ID = X.id
    LEFT JOIN player Y ON M.player2ID = Y.id
    JOIN club C ON tbl.clubID = C.id
WHERE tbl.clubID=? ORDER BY 2
";


	$data = query($query, $clubID);
	$data_count = count($data);

	generalHeader($clubName, $clubPhoto);
	
	for($i=0; $i < $data_count; $i++)
	{
		$id = $data[$i][0]; $number = $data[$i][1];
		$status = $data[$i][2];	
		$plr1 = $data[$i][3]; $plr2 = $data[$i][4];
		$img1 = $data[$i][5]; $img2 = $data[$i][6];
		$pts1 = $data[$i][7]; $pts2 = $data[$i][8];
		$bestOf = $data[$i][9];

		$status = castStatus($status);
		tableHeader($status, $number, $id);

		if($status == "busy")
			displayTable($plr1,$img1,$plr2,$img2,$pts1,$pts2,$bestOf);
		
		tableFooter();
	}

	generalFooter();


function castStatus($status)
{
	if($status=="Occupied")
		return "busy";
	if($status=="Available")
		return "free";
}


function buttonHeader($clubID)
{ ?>
	<form action="lobby.php" method="post">
		<input type="hidden" name="club" value="<?=$clubID?>"/>
		Турір <select name="tournament">
<?php }
function displayTournament($id, $name)
{ ?>
			<option value="<?=$id?>"><?=$name?></option>
<?php }
function buttonFooter()
{ ?>
		<input type="submit" name="occupy" value="Зайняти столи"/>
	</form>
<?php }



function generalHeader($clubName, $clubPhoto)
{ ?>
	<div class="sub-container">
		<div class="section_header">
				<img class="circle_img_clb float_right" alt="logo"
				src="<?=CLUB_IMG.$clubPhoto?>">
			<div class="header_sign">
				<i class="fas fa-shield-alt"></i>
				<?=$clubName?>
			</div>
		</div>
		<div class="club_tables_container">
<?php }
function generalFooter()
{ ?>
		</div>
	</div>
<?php }



function tableHeader($b_f, $number, $id)
{ ?>
		<div class="stable_containers pointer"
		onclick="openTableLobby(<?=$id?>);">
			<div id="<?=$b_f?>" class="header_box">
				<span class="stable_num_header">
					Стіл #<?=$number?>
				</span>
			</div>
			<div class="<?=$b_f?>_stable_container">
				<div class="<?=$b_f?>_stable_box">
<?php if($b_f=="free") { ?>
					<span class="<?=$b_f?>_stable_num">
						#<?=$number?>
					</span>
<?php }
}
function tableFooter()
{ ?>
				</div>
			</div>
		</div>
<?php }



function displayTable($plr1, $img1, $plr2, $img2, $pts1,$pts2,$bestOf)
{ ?>
					<div class="boxFor_plName">
						<span class="plName stable_plName_left">
							<?=$plr1?>
						</span>
						<span class="plName stable_plName_right">
							<?=$plr2?>
						</span>
					</div>
					<div class="boxFor_imgs">
						<div class="circle_img_box_left">
							<img class="circle_player_img" src="<?=PLAYER_IMG.$img1?>" alt="фото гравця">
						</div>
						<div class="current_game_info">
							<span class="points_num"><?=$pts1?></span>
							<span id="frame_num">(<?=$bestOf?>)</span>
							<span class="points_num"><?=$pts2?></span>
						</div>
						<div class="circle_img_box_right">
							<img class="circle_player_img" src="<?=PLAYER_IMG.$img2?>" alt="фото гравця">
						</div>
					</div>
<?php }
?>

