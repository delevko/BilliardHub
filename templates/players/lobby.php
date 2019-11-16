
<?php
	require("tournamentList.php");
	require("tournamentBreaksList.php");
?>

<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/player_profile.css">
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/player_tournaments_list.css"> 
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/player_breaks.css"> 

	<div class="table_list">
		<div class="player_profile_section01">
			<div class="player_profile_photo">
				<img class="player_profile_img"
				src="<?=PLAYER_IMG.$img?>" alt="Фото гравця">
			</div>
			<div class="player_profile_personalInfo">
				<table>
					<th colspan="2">
						<div class="player_profile_playerName">
							<i class="fas fa-user"></i>
							<div class="player_profile_header">
								<?=$fName?> <span class="player_profile_surname"> <?=$lName?></span>
							</div>
						</div>
						
					</th>
					<tr>
						<td>
							<div class="player_profile_country">
								<div class="player_profile_tableHeader">країна</div>
								<div class="player_profile_tableMean"><?=$country?></div>
							</div>
						</td>
						<td>
							<div class="player_profile_city">
								<div class="player_profile_tableHeader">місто</div>
								<div class="player_profile_tableMean"><?=$city?></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="player_profile_age">
								<div class="player_profile_tableHeader">дата народження</div>
								<div class="player_profile_tableMean"><?=$birthday?></div>
							</div>
						</td>
						<td>
							<div class="player_profile_maxBreak">
								<div class="player_profile_tableHeader">найвищий турнірний<br>брейк</div>
								<div class="player_profile_tableMean max_break"><?=$highestBreak?></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div> <br>


		<!-- MOBILE RESPONSIVE SECTION 01 (VERTICAL) -->

		<div class="player_profile_section_ver">
			<div class="player_profile_playerName">
							<i class="fas fa-user"></i>
							<div class="player_profile_header"><?=$fName?> <span class="player_profile_surname"> <?=$lName?></span>
							</div>
						</div>
			<div class="player_profile_photo">
					<img class="player_profile_img" src="<?=PLAYER_IMG.$img?>" alt="Фото гравця">
			</div>
			<div class="player_profile_personalInfo">
				<table>
					<tr>
						<td>
							<div class="player_profile_country">
								<div class="player_profile_tableHeader">країна</div>
								<div class="player_profile_tabelMean"><?=$country?></div>
							</div>
						</td>
						<td>
							<div class="player_profile_city">
								<div class="player_profile_tableHeader">місто</div>
								<div class="player_profile_tabelMean"><?=$city?></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="player_profile_age">
								<div class="player_profile_tableHeader">дата народження</div>
								<div class="player_profile_tabelMean"><?=$birthday?></div>
							</div>
						</td>
						<td>
							<div class="player_profile_maxBreak">
								<div class="player_profile_tableHeader">найвищий турнірний брейк</div>
								<div class="player_profile_tabelMean max_break"><?=$highestBreak?></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div> <br>
		





			<!-- SECTION 02 (CIRCLES) -->

		<div class="player_profile_section02">
			<a class="player_profile_circle highlight_anchor"
			onclick="player_profile(event, 'tournaments_')"
			href="#tournaments_">
				<div class="little_circle">
					<?=$tournamentCtr?>
				</div>
				<i class="fas fa-trophy"></i><br>
				<span class="circle_text">турніри</span>
			</a>
			<a class="player_profile_circle highlight_anchor"
			onclick="player_profile(event, 'tournaments_b')"
			href="#tournaments_b">
				<div class="little_circle">
					<?=$breakCtr?>
				</div>
				<i class="fas fa-trophy"></i> <br>
				<span class="circle_text">брейки</span>
			</a>
<!--
			<div class="player_profile_circle highlight_anchor">
				<div class="little_circle">
					x
				</div>
				<i class="fas fa-user-friends"></i><br>
				<span class="circle_text">спаринги</span>
			</div>
			<div class="player_profile_circle highlight_anchor">
				<div class="little_circle">
					x
				</div>
				<i class="fas fa-user-friends"></i> <br>
				<span class="circle_text">брейки</span>
			</div>
-->
		</div>
	</div>
	<div class="player_profile_details">
        <div id="tournaments_" class="details_anchor">
        	<?php tournamentList($playerID); ?>
	</div>

        <div id="tournaments_b" class="details_anchor">
		<?php tournamentBreaksList($playerID); ?>
        </div>
    </div>


    <script type="text/javascript" src="<?=PATH_H?>js/player_profile.js">
    </script>

