<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/lobby_list.css"> 


<?php
//bracket, tournamentID

$query = "SELECT
    M.counter, 
    CONCAT(X.firstName, ' ', X.lastName) AS player1Name,
    CONCAT(Y.firstName, ' ', Y.lastName) AS player2Name,
    M.bestOF, M.player1Score, M.player2Score,
    LM.points1, LM.points2, LM.break1, LM.break2,
    X.photo AS photo1, Y.photo AS photo2, M.id AS matchID,
    M.roundType, M.roundNo
FROM _match M
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
    JOIN matchDetails MD ON M.id = MD.matchID
    LEFT JOIN liveMatch LM ON LM.matchID = M.id
WHERE M.tournamentID=? AND MD.status=? ORDER BY M.counter
";



$data = query($query, $tournamentID, "Live");
$data_count = count($data);

//live matches exist
if($data_count > 0)
{
	//print all of them
	for($i = 0; $i < $data_count; $i++)
	{
		$counter = $data[$i][0];
		$player1 = $data[$i][1]; $player2 = $data[$i][2];
		$bestOf = $data[$i][3];

		$score1 = $data[$i][4]; $score2 = $data[$i][5];
		$points1 = $data[$i][6]; $points2 = $data[$i][7];
		$break1 = $data[$i][8]; $break2 = $data[$i][9];
		$img1 = $data[$i][10]; $img2 = $data[$i][11];
		$matchID = $data[$i][12];
		$rndType = $data[$i][13]; $rndNo = $data[$i][14];
		$rndType = castMatchHeader($rndType);

		displayHeader($matchID, $counter, $rndType, $rndNo);

		printLiveMatch($player1, $score1, $points1, $break1, $img1, $player2, $score2, $points2, $break2, $img2, $bestOf);

		displayFooter();
	}
}
else
{
	?><h3>Немає жодних матчів</h3><?php
}




function printPlayer($name, $img)
{ ?>
			<div class="list-match-lobby-player">
				<span class="list-match-lobby-player-name">
					<?=$name?>
				</span>
				<p>
					<img class="list-match-lobby-player-img" alt="img"
					src="<?=PLAYER_IMG.$img?>">
				</p>
			</div>
<?php }



function displayHeader($matchID, $matchNo, $rndType, $rndNo)
{ ?>
   <div class="list-match-lobby pointer"
	onclick="openMatchLobby(<?=$matchID?>);">
		<h3 class="list-match-lobby-info">
			Зустріч #<?=$matchNo?>&emsp; | &emsp;<?=$rndType?><?=$rndNo?>
		</h3>
<?php }

function printLiveMatch($player1, $score1, $points1, $break1, $img1, $player2, $score2, $points2, $break2, $img2, $bestOf)
{ ?>
		<div class="list-match-lobby-player-table">
			<?php printPlayer($player1, $img1); ?>
			<div class="list-match-lobby-frame-section">
				<table class="list-match-lobby-frame-table">
					<tbody>
						<tr>
							<td><?=$score1?></td>
							<th>Фрейми</th>
							<td><?=$score2?></td>
						</tr>
						<tr class="list-match-lobby-frame-details">
							<td colspan="3">Best of <?=$bestOf?></td>
						</tr>
						<tr>
							<td><?=$points1?></td>
							<th>Очки</th>
							<td><?=$points2?></td>
 						</tr>
						<tr class="list-match-lobby-frame-details">
							<td colspan="3"></td>
						</tr>
						<tr>
							<td><?=$break1?></td>
							<th>Брейк</th>
							<td><?=$break2?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php printPlayer($player2, $img2); ?>
		</div>
<?php }

function displayFooter()
{ ?>
	</div>
	<div class="margin-b_30"></div>
<?php }
?>
