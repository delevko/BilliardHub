<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/group.css"> 

<?php
//tournamentID

	$query = "SELECT nrOfGroups FROM tournament WHERE id=?";
	$data = query($query, $tournamentID);
	$G_R = $data[0][0];


	for($i = 1; $i <= $G_R; $i++)
	{
		groupHeader($i);

		printGroup($tournamentID, $i);

		groupFooter();
	}



function groupHeader($i)
{ ?>
		<div class="section_header">
			<div class="header_sign">
				ГРУПА <?=$i?>
			</div>
		</div>
		<div class="list_container">
<?php }
function groupFooter()
{?>
		</div>
		<div class="margin-b_30"></div>
<?php }



function tableHeader($N)
{ ?>
			<table class="list_table group_table">	
				<thead>
					<th>#</th>
					<th>
						<i class="fas fa-user"></i>
						<span>Гравець</span>
					</th>
					<?php for($i=1;$i<=$N;$i++) print("<th>$i</th>"); ?>
					<th>m</th>
					<th>+m</th>
					<th>-m</th>
					<th>Δm</th>
					<th>+f</th>
					<th>-f</th>
					<th>Δf</th>
					<th>%</th>
				</thead>
				<tbody>
<?php }
function tableFooter()
{ ?>
				</tbody>
			</table>
<?php }



function printGroup($tournID, $groupNo)
{
    $query = "SELECT PG.playerNum AS playerNum,
    CONCAT(P.firstName, ' ', P.lastName) AS playerName,
    PG.playerID AS playerID, GS.seed AS playerSeed,
    P.photo AS playerPhoto
FROM groupTournament AS GT
    LEFT JOIN playerGroup AS PG
        ON GT.id = PG.groupID
    LEFT JOIN player AS P
        ON PG.playerID = P.id
    LEFT JOIN groupSeeding GS
        ON GS.playerID = P.id AND GS.tournamentID = GT.tournamentID
WHERE GT.tournamentID=? AND GT.groupNum=? ORDER BY PG.playerNum
";


    $data = query($query, $tournID, $groupNo);
	$n_plrs = count($data);
	
	tableHeader($n_plrs);

	for($i = 0; $i < $n_plrs; $i++)
    {
        $plrNo = $data[$i][0]; $name = $data[$i][1];
		$id = $data[$i][2]; $seed = $data[$i][3];
		$img = $data[$i][4];

		$e_o = ($i%2) ? "even" : "odd";
		$BR = ($i+1 == $n_plrs) ? " radius_br" : "";
		$BL = ($i+1 == $n_plrs) ? " radius_bl" : "";


		playerHeader($e_o, $BL, $id, $name, $plrNo, $seed, $img);
		
		displayMatches($tournID, $groupNo, $plrNo, $n_plrs);
		displayStatistics($tournID, $groupNo, $plrNo, $BR);

		playerFooter();
    }

	tableFooter();
}



function playerHeader($e_o, $BL, $id, $name, $number, $seed, $img)
{ ?>
		<tr class="tbody_<?=$e_o?>">
			<td class="<?=$e_o?>_num<?=$BL?> bold">
				<?=$number?>
			</td>
			<td class="photo_name pointer"
			onclick="openPlayerLobby(<?=$id?>);">
				<img class="circle_img" src="<?=PLAYER_IMG.$img?>"
				alt="img">
				<span>
					<?=$name?> (<?=$seed?>)
				</span>
			</td>
<?php }
function playerFooter()
{ ?>
		</tr>
<?php }



function displayMatches($id, $grpNo, $plrNo, $n_plrs)
{	
	$query = "SELECT M.id AS matchID, MD.status,
    IF(PG1.playerNum=?, PG2.playerNum, PG1.playerNum) AS enemyNum,
    IF(PG1.playerNum=?, M.player1Score, M.player2Score) AS myScore,
    IF(PG1.playerNum=?, M.player2Score, M.player1Score) AS enemyScore
FROM _match M
    JOIN playerGroup PG1 ON M.player1ID = PG1.playerID
        AND M.groupID = PG1.groupID
    JOIN playerGroup PG2 ON M.player2ID = PG2.playerID
        AND M.groupID = PG2.groupID
    JOIN groupTournament GT ON M.groupID = GT.id
        AND GT.tournamentID = M.tournamentID
    JOIN matchDetails MD ON M.id = MD.matchID
WHERE M.tournamentID=? AND GT.groupNum=?
        AND (PG1.playerNum=? OR PG2.playerNum=?) ORDER BY enemyNum
";


	$data = query($query,$plrNo,$plrNo,$plrNo,$id,$grpNo,$plrNo,$plrNo);
	
	$k = 0;
	$matches = $mWon + $mLost;
	for($i=1; $i <= $n_plrs; $i++)
	{
		$mID = $data[$k][0];
		$score1 = $data[$k][3]; $score2 = $data[$k][4];

		if($i === $plrNo) {
			print("<td>X</td>");
		} else {
			displayMatch($mID, $score1, $score2);
			$k++;
		}
	}
}

function displayMatch($mID, $score1, $score2)
{ ?>
			<td class="pointer" onclick="openMatchLobby(<?=$mID?>);">
				<?=$score1?>:<?=$score2?>
			</td>
<?php }



function displayStatistics($tournID, $groupNo, $playerNo, $BR)
{
	$query = "SELECT PG.mWon, PG.mLost, PG.fWon, PG.fLost 
		FROM playerGroup PG JOIN groupTournament GT 
		ON PG.groupID = GT.id WHERE GT.tournamentID=?
		AND PG.playerNum=? AND GT.groupNum=?";
	$data = query($query, $tournID, $playerNo, $groupNo);
	$mWon = $data[0][0]; $mLost = $data[0][1];	
	$fWon = $data[0][2]; $fLost = $data[0][3];	

	$matches = $mWon + $mLost;
	$dMatches = ($matches !== 0) ? $mWon/$matches : 0;
	$dFrames = ($fWon+$fLost !== 0) ? $fWon/($fWon+$fLost) : 0;
	$res = ( (4/3)*$dMatches + (2/3)*$dFrames ) / 2;
	$res = round($res*100, 2);
	displayStat($matches, $mWon, $mLost, $fWon, $fLost,$BR,$res);
}

function displayStat($matches,$mWon,$mLost,$fWon,$fLost,$BR,$res)
{ ?>
			<td><?=$matches?></td>
			<td><?=$mWon?></td>
			<td><?=$mLost?></td>
			<td><?=($mWon-$mLost)?></td>
			<td><?=$fWon?></td>
			<td><?=$fLost?></td> 
			<td><?=($fWon-$fLost)?></td>
			<td class="<?=$BR?>"><?=$res?>%</td>
<?php
}

