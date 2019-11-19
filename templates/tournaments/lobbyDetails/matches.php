<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/match_list.css">


<?php
//bracket, tournamentID

if( !strcmp($bracket, "K/O") )
{
	$query = "SELECT T.KO_Rounds, T.seeded_Round
		FROM tournament T WHERE T.id=?";
	$data = query($query, $tournamentID);
    
	$KO_R = $data[0][0]; $seeded_R = $data[0][1];

	prepareRound("K/O", $KO_R, $tournamentID, $seeded_R);
}
else if( !strcmp($bracket, "D/E") )
{
	$query = "SELECT T.UP_Rounds, T.LOW_Rounds, T.KO_Rounds,
		T.seeded_Round FROM tournament T WHERE T.id=?";
	$data = query($query, $tournamentID);
   
	$UP_R = $data[0][0]; $LOW_R = $data[0][1]; 
	$KO_R = $data[0][2]; $seeded_R = $data[0][3];

	prepareRound("UP", $UP_R, $tournamentID, $seeded_R);
	prepareRound("LOW", $LOW_R, $tournamentID, $seeded_R);
	prepareRound("K/O", $KO_R, $tournamentID, $seeded_R);
}
else if( !strcmp($bracket, "GroupKO") )
{
	$query = "SELECT T.nrOfGroups, T.KO_Rounds, T.seeded_Round
		FROM tournament T WHERE T.id=?";
	$data = query($query, $tournamentID);

	$G_R = $data[0][0]; $KO_R = $data[0][1];
	$seeded_R = $data[0][2];

	prepareRound("Group", $G_R, $tournamentID, $seeded_R);
	prepareRound("K/O", $KO_R, $tournamentID, $seeded_R);
}



function prepareRound($roundType, $R, $tournamentID, $seeded_R)
{
	for($i = 1; $i <= $R; $i++)
	{
		roundDetails(castHeader($roundType,$i,$R,$seeded_R));

		roundHeader();
		
		displayRound($tournamentID, $roundType, $i);

		roundFooter();
	}
}


function roundDetails($header)
{ ?>
		<div class="section_header">
			<div class="header_sign">
				<span>
					<?=$header?>
				</span>
			</div>
		</div>
<?php }

function roundHeader()
{ ?>
	<div class="list_container margin-b_30">
	<table class="list_table matches_list_table">
		<colgroup>
			<col class="col-1">
			<col class="col-2">
			<col class="col-3">
			<col class="col-4">
			<col class="col-5">
			<col class="col-6">
			<col class="col-7">
			<col class="col-8">
			<col class="col-9">
		</colgroup>
		<thead>
			<tr>
				<th>#</th>
				<th class="float_right">
					<i class="fas fa-user"></i>
					<span>Гравець 1</span>
				</th>
				<th></th>
				<th></th>
				<th>v</th>
				<th></th>
				<th></th>
				<th class="float_left">
					<i class="fas fa-user"></i>
					<span>Гравець 2</span>
				</th>
				<th>
					<span>TV</span>
				</th>
			</tr>
		</thead>
		<tbody>
<?php }

function roundFooter()
{ ?>
		</tbody>
	</table>
	</div>
<?php }



function displayMatch($tID,$counter,$last,$mID,$player1,$score1,$player2,$score2,$bestOf,$link,$live)
{
	$e_o = ($counter%2) ? "odd" : "even"; 
?>
	<tr onclick='openMatchLobby(<?=$tID?>, <?=$mID?>);'
		class="tbody_<?=$e_o?> pointer">
		<td class="bold <?=$e_o?>_num<?=($last)?" radius_bl":""?>">
			<?=$counter?>
		</td>
		<td>
		<?php if ($live) { ?>
			<span class="float_left live">live</span>
		<?php } ?>
			<span class="float_right">
				<?=$player1?>
			</span>
		</td>
		<td>
		</td>
		<td>
			<span class="font_20 bold float_right">
				<?=$score1?>
			</span>
		</td>
		<td>
			<span>
				(<?=$bestOf?>)
			</span>
		</td>
		<td>
			<span class="font_20 bold float_left">
				<?=$score2?>
			</span>
		</td>
		<td>
		</td>
		<td>
			<span class="float_left">
				<?=$player2?>
			</span>
		</td>
		<td class="matches_list_table_youtube
		<?=$e_o?>_youtube 
		 <?=($last)?" radius_br":""?>"
		<?php if(isset($link)){ ?>
			onclick="openYoutube(event,<?=("'".YT_HEADER.$link."'")?>);"
		<?php } ?>>
			<?php if(isset($link)){ ?>
				<i class="fab fa-youtube"></i>
			<?php } ?>
		</td>
	</tr>


<?php }



function displayRound($tournID, $rType, $rNo) 
{
    $grpORround = ($rType=="Group") ? "GT.groupNum=?" : "M.roundNo=?"; 
    $query = "SELECT M.counter, M.id AS matchID, 
    CONCAT(X.firstName, ' ', X.lastName) AS player1Name,
    CONCAT(Y.firstName, ' ', Y.lastName) AS player2Name,
    M.bestOF, M.player1Score, M.player2Score, MD.status,
    M.youtube
FROM _match M
    JOIN player X ON M.player1ID=X.id
    JOIN player Y ON M.player2ID=Y.id
    JOIN matchDetails MD ON M.id = MD.matchID
LEFT JOIN groupTournament GT ON M.groupID = GT.id
WHERE M.tournamentID=? AND M.roundType=? AND ".$grpORround.
" ORDER BY M.counter";

    $data = query($query, $tournID, $rType, $rNo);
	
	$data_counter = count($data);
    for($i = 0; $i < $data_counter; $i++)
    {
        $counter = $data[$i][0]; $matchID = $data[$i][1];
        $player1 = $data[$i][2]; $player2 = $data[$i][3];
	$bestOf = $data[$i][4];
        $score1 = $data[$i][5]; $score2 = $data[$i][6];
	$status = $data[$i][7]; $youtube = $data[$i][8];
	
	$last = ($i+1 < $data_counter) ? false : true;
	$live = ($status=="Live");

		displayMatch($tournID,$counter,$last,$matchID, $player1, $score1, $player2, $score2, $bestOf, $youtube, $live);
	}
}

