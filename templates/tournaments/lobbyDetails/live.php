<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/lobby_list.css"> 


<?php
//bracket, tournamentID

$query = "SELECT M.id, M.counter, M.roundType FROM _match M
	JOIN matchDetails MD ON MD.matchID=M.id
	WHERE M.tournamentID=? AND MD.status=? ORDER BY M.counter";
$data = query($query,$tournamentID, "Live");
$data_count = count($data);

for($i = 0; $i < $data_count; $i++)
{
    $id = $data[$i][0]; $counter = $data[$i][1];
    $rType = $data[$i][2];

    printMatch($id, $counter, $rType);
}

if($data_count < 1)
{
	?><h3>Немає жодних матчів</h3><?php
}




function printMatch($id, $counter, $rType)
{
    $grpORround = ($rType=="Group") ? "GT.groupNum" : "M.roundNo";

    $query = "SELECT
    M.counter, 
    CONCAT(X.firstName, ' ', X.lastName) AS player1Name,
    CONCAT(Y.firstName, ' ', Y.lastName) AS player2Name,
    M.bestOF, M.player1Score, M.player2Score,
    LM.points1, LM.points2, LM.break1, LM.break2,
    X.photo AS photo1, Y.photo AS photo2, M.id AS matchID,
    M.roundType, ".$grpORround.", T.KO_Rounds, T.seeded_Round
FROM _match M
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
    JOIN matchDetails MD ON M.id = MD.matchID
    JOIN tournament T ON M.tournamentID=T.id
    LEFT JOIN liveMatch LM ON LM.matchID = M.id
    LEFT JOIN groupTournament GT ON M.groupID = GT.id
WHERE M.id=?";

    $data = query($query, $id);

	$counter = $data[0][0];
	$player1 = $data[0][1]; $player2 = $data[0][2];
	$bestOf = $data[0][3];

	$score1 = $data[0][4]; $score2 = $data[0][5];
	$points1 = $data[0][6]; $points2 = $data[0][7];
	$break1 = $data[0][8]; $break2 = $data[0][9];
	$img1 = $data[0][10]; $img2 = $data[0][11];
	$matchID = $data[0][12];
	$rndType = $data[0][13]; $rndNo = $data[0][14];

	$KO_R = $data[0][15]; $seeded_R = $data[0][16];
	$header = castHeader($rndType,$rndNo,$KO_R,$seeded_R);


	displayHeader($matchID, $counter, $header);

	printLiveMatch($player1, $score1, $points1, $break1, $img1, $player2, $score2, $points2, $break2, $img2, $bestOf);

	displayFooter();
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



function displayHeader($matchID, $matchNo, $header)
{ ?>
   <div class="list-match-lobby pointer"
	onclick="openMatchLobby(<?=$matchID?>);">
		<h3 class="list-match-lobby-info">
			Зустріч #<?=$matchNo?>&emsp; | &emsp;<?=$header?>
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
