
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/match_lobby.css"> 
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/lobby_list.css">

<?php

$matchID = isset($_GET["matchID"]) ? $_GET["matchID"] : null;
if( !nonEmpty($matchID) || !exists("_match", $matchID) )
{
	redirect("");
}

lobby($matchID);

?></div><?php


function lobby($matchID)
{
	list($counter, $roundType, $roundNo, $bestOF,
		$id1, $name1, $score1, $img1,
		$id2, $name2, $score2, $img2,
		$KO_R, $seeded_R, $youtube, $status) = getMatchData($matchID);


	$live = ($status == "Live");	
	if( nonEmpty($youtube) )
		displayLive($youtube);
	else {
		?><div class="match_margin"></div><?php
	}

	$header = castHeader($roundType,$roundNo,$KO_R,$seeded_R);

	if($live)
	{
	     displayLiveHeader($matchID, $counter, $header);

	     list($points1,$points2,$break1,$break2) = getLiveData($matchID);
 
	     displayLiveMatch($id1,$name1,$score1,$points1,$break1,$img1,$id2,$name2,$score2,$points2,$break2,$img2,$bestOF);
	
	     displayLiveFooter();

             if($score1 + $score2 > 0)
             {
		framesHeader();

		printFrames($matchID);

		framesFooter();
             }
	}
	else
	{
	    printLobby($counter, $header, $bestOF,
		$id1, $name1, $score1, $img1, $id2, $name2, $score2, $img2);

	    if( isset($score1) )
	    {
		framesHeader();

		printFrames($matchID);

		framesFooter();
 	    }
	}
}


function displayLive($youtube)
{ ?>
    <div class="youtube_logo">
        <a href="<?=YT_HEADER?><?=$youtube?>">
	    <i class="fab fa-youtube"></i>
        </a>
    </div>
<?php }


function displayLiveHeader($mID, $matchNo, $header)
{ ?>
   <meta http-equiv="refresh" content="5;">
   <div class="list-match-lobby margin_top_none">
	<h3 class="list-match-lobby-info">
		ЗУСТРІЧ #<?=$matchNo?>&emsp; | &emsp;<?=$header?>
	</h3>
<?php }
function displayLiveFooter()
{ ?>
    </div>
<?php }


function printPlayer($id, $name, $img)
{ ?>
                        <div class="list-match-lobby-player pointer"
			onclick="openPlayerLobby(<?=$id?>)">
                                <span class="list-match-lobby-player-name">
                                        <?=$name?>
                                </span>
                                <p>
                                        <img class="list-match-lobby-player-img" alt="img"
                                        src="<?=PLAYER_IMG.$img?>">
                                </p>
                        </div>
<?php }


function displayLiveMatch($id1,$player1,$score1,$points1,$break1,$img1,$id2,$player2,$score2,$points2,$break2,$img2,$bestOf)
{ ?>
                <div class="list-match-lobby-player-table">
                        <?php printPlayer($id1, $player1, $img1); ?>
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
                        <?php printPlayer($id2, $player2, $img2); ?>
                </div>
<?php }


function printLobby($counter, $header, $bestOF, $id1, $name1, 
	$score1, $img1, $id2, $name2, $score2, $img2)
{ ?>
	<div class="match_lobby">
		<div class="match_lobby_info">
			<span>
			Зустріч #<?=$counter?>&emsp; | &emsp;<?=$header?>
			</span>
		</div>
		<div class="match_lobby_player-table">
			<div class="match_lobby_player pointer"
<?php if($id1 !== -1 && $id1 !== -2){ ?>
			onclick="openPlayerLobby(<?=$id1?>);"
<?php } ?>		>
				<span class="match_lobby_player-name float_left
				<?=$name1=="WALK OVER"?" walk_over":""?>">
					<?=$name1?>
				</span>
				<p>
					<img class="match_lobby_player-img" alt="player01" src="<?=PLAYER_IMG.$img1?>"></img>
				</p>
			</div>
			<div class="match_lobby_frame-section">
				<table class="match_lobby_frame-table">
					<tbody>
						<tr>
							<td><?=$score1?></td>
							<th>v</th>
							<td><?=$score2?></td>
						</tr>
						<tr class="match_lobby_frame-details">
							<td colspan="3">
								Best of <?=$bestOF?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="match_lobby_player pointer"
<?php if($id2 !== -1 && $id2 !== -2){ ?>
			onclick="openPlayerLobby(<?=$id2?>);"
<?php } ?>		>
				<span class="match_lobby_player-name float_right
				<?=$name2=="WALK OVER"?" walk_over":""?>">
					<?=$name2?>
				</span>
				<p>
					<img class="match_lobby_player-img" alt="player02" src="<?=PLAYER_IMG.$img2?>"></img>
				</p>
			</div>
		</div>
	</div>

<?php }


function framesHeader()
{ ?>

	<div class="">
		<table class="match_lobby_table">
			<colgroup>
				<col class="col-1">
				<col class="col-2">
				<col class="col-3">
				<col class="col-4">
				<col class="col-5">
			</colgroup>
			<thead>
				<tr>
					<th>
						<span>брейки</span>
					</th>
					<th>
						<span>очки</span>
					</th>
					<th>
						<span class="non_res">фрейм</span>
						<span class="res">#</span>
					</th>
					<th>
						<span>очки</span>
					</th>
					<th>
						<span>брейки</span>
					</th>
				</tr>
			</thead>
			<tbody>
<?php }


function printFrame($counter, $score1, $score2, $breaks1, $breaks2, $BL, $BR, $TL, $TR)
{ 
	$e_o = ($counter%2) ? "odd" : "even";
?>

	<tr class="tbody_<?=$e_o?>">
		<td class="match_lobby_table_name_left <?=$BL?> <?=$TL?>">
			<?=$breaks1?>
		</td>
		<td class="match_lobby_table_name_left">
			<?=$score1?>
		</td>
		<td class="match_lobby_table_number <?=$e_o?>_num">
			<?=$counter?>
		</td>
		<td class="match_lobby_table_date_center">
			<?=$score2?>
		</td>
		<td class="match_lobby_table_date_left <?=$BR?> <?=$TR?>">
			<?=$breaks2?>
		</td>
	</tr>

<?php }

function framesFooter()
{ ?>

		</tbody>
	</table>
</div>

<?php }

function printFrames($matchID)
{
	$query = "SELECT F.counter, F.points1, F.points2 
		FROM frame F WHERE F.matchID=? ORDER BY F.counter";
	$data = query($query, $matchID);
	$data_count = count($data);

	for($i = 0; $i < $data_count; $i++)
	{
		$frame = $data[$i][0];
		$points1 = $data[$i][1]; $points2 = $data[$i][2];
		
		$query = "SELECT B.XorY, B.points FROM break B
			WHERE B.frameCounter=? AND B.matchID=? ORDER BY 1, 2 DESC";
		$breaks = query($query, $frame, $matchID);
		$breaks1 = ""; $breaks2 = "";

		$break_count = count($breaks);
		for($j = 0; $j < $break_count; $j++)
		{
			$xORy = $breaks[$j][0]; $points = $breaks[$j][1];
			if($xORy) $breaks1 .= ($points.", ");
			else $breaks2 .= ($points.", ");
		}
		$breaks1 = substr($breaks1, 0, -2);
		$breaks2 = substr($breaks2, 0, -2);

		
		$TL = ""; $TR = "";
		$BL = ""; $BR = "";
		if($i === 0){
			$TL = "radius_tl"; $TR = "radius_tr";
		}
		if($i+1 >= $data_count){
			$BL = "radius_bl"; $BR = "radius_br";
		}

		printFrame($i+1, $points1, $points2, $breaks1, $breaks2, $BL, $BR, $TL, $TR);
	}
	
	if( $data_count > 0 )
		framesFooter();
}


function getMatchData($matchID)
{
    $data = query("SELECT M.roundType FROM _match M
	WHERE M.id=?", $matchID);
    $rType = $data[0][0];

$grpORround = ($rType=="Group") ? "GT.groupNum" : "M.roundNo";

    $query = "SELECT M.counter, M.roundType,".$grpORround.", M.bestOF, 
    M.player1ID, CONCAT(X.firstName, ' ', X.lastName) AS Player1,
    M.player1Score, X.photo AS photo1,
    M.player2ID, CONCAT(Y.firstName, ' ', Y.lastName) AS Player2,
    M.player2Score, Y.photo AS photo2, T.KO_Rounds, T.seeded_Round,
    M.youtube, MD.status
FROM _match M
    JOIN matchDetails MD ON M.id=MD.matchID
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
    JOIN tournament T ON M.tournamentID=T.id
LEFT JOIN groupTournament GT ON M.groupID = GT.id
WHERE M.id=?";
	
    $data = query($query, $matchID);


	return array($data[0][0],$rType,$data[0][2],$data[0][3],$data[0][4],$data[0][5],$data[0][6],$data[0][7],$data[0][8],$data[0][9],$data[0][10],$data[0][11],$data[0][12],$data[0][13], $data[0][14], $data[0][15]);

}

function getLiveData($matchID)
{
    $query = "SELECT LM.points1, LM.points2, LM.break1, LM.break2
	FROM liveMatch LM WHERE LM.matchID=?";
    $data = query($query, $matchID);

    return array($data[0][0],$data[0][1],$data[0][2],$data[0][3]);
}
?>
