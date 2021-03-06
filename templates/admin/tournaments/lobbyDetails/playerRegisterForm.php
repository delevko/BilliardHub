<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/tournament_lobby.css"> 
</head>

<?php

$query = "SELECT
    P.id, CONCAT(P.lastName, ' ', P.firstName) AS playerName
FROM (SELECT @getVal:=?) d, player P
WHERE P.id NOT IN (-1,-2)
AND P.id NOT IN
    (SELECT PT.playerID FROM playerTournament PT WHERE tournamentID=getVal()) order by 2;
";

$data = query($query, $tournamentID);
if(count($data))
{
?>
	<div class="margin-b_30"></div>
		<form class="player_admin_reg_box" action="playerRegister.php" method="post">
			<div class="player_admin_reg_select">
				<select name="player">
					<?php
						
					for($i=0; $i<count($data); $i++)
					{
						$playerID = $data[$i][0];
						$playerName = $data[$i][1];
		?>
						<option value="<?=$playerID?>"><?=$playerName?></option>
			  <?php } ?>
				</select>
			</div>
			<input type="hidden" name="tournament" value="<?=$tournamentID?>">
			<button class="player_admin_reg_button nonres_reg_button" type="submit">Зареєструвати гравця</button>
			<button class="player_admin_reg_button res_reg_button" type="submit">Зареєструвати</button>
			<div class="margin-b_30"></div>
		</form>
<?php
} ?>


<div class="tournamentNavigation">
	<form action="registration/stop.php" method="post">
		<input type="hidden" name="id" value="<?=$tournamentID?>">
		<button type="submit">Закінчити реєстрацію</button>
	</form>
</div>

