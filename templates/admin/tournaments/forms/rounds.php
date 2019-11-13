<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/rounds_form.css">

		<div class="margin-b_30"></div>
	<div class="rounds_box">
            <div class="rounds_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="rounds_header">
                <span>ВВЕДІТЬ ДЕТАЛІ ТУРНІРУ</span>
            </div>
	    <form class="r_box" method="post"
		action="start/rounds.php">
		<div class="rounds_form">
		    <div class="data_field">
			<span class="bold">
			    Рейтингові очки за виліт у раунді:
			</span>
			<div class="margin-b_30"></div>
		        <?php displayRounds($tournamentID, $bracket); ?>
		    </div>
		    <div class="data_field">
			<span class="bold">
			    Best of для раунду:
			</span>
			<div class="margin-b_30"></div>
		        <?php displayBestOf($tournamentID, $bracket); ?>
		    </div>
		</div>
		<input type="hidden" name="id" value="<?=$tournamentID?>">
		<div class="margin-b_30"></div>
	        <input type="number" name="minBreak"
		    placeholder="Мінімальний брейк">
		<span class="date_format">
			*20 за замовчуванням
		</span>
		<button>Заповнити та розпочати</button>
	    </form>
        </div>


<?php

function displayInput($name, $placeholder)
{ ?>
		<input type="number" name="<?=$name?>"
		placeholder="<?=$placeholder?>">
<?php }


function displayBestOf($id, $bracket)
{
    if($bracket == "D/E")
	DE_bestOf($id);
    else if($bracket == "K/O")
	KO_bestOf($id);
    else if($bracket == "GroupKO")
    {
	displayInput("GROUP_B", "Груповий етап");
        ?><div class="margin-b_30"></div><?php
	KO_bestOf($id);
    }
}

function DE_bestOf($id)
{
    $query = "SELECT T.LOW_Rounds, T.UP_Rounds, T.KO_Rounds
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $LOW_R = $data[0][0]; $UP_R = $data[0][1]; $KO_R = $data[0][2];

    for($i = 1; $i <= $LOW_R; $i++)
    {
	displayInput("LOW_B-$i", "НИЖНЯ СІТКА - РАУНД $i");
    }

    ?><div class="margin-b_30"></div><?php
    
    for($i = 1; $i <= $UP_R; $i++)
    {
	displayInput("UP_B-$i", "ВЕРХНЯ СІТКА - РАУНД $i");
    }

    ?><div class="margin-b_30"></div><?php

    for($i = 1; $i <= $KO_R; $i++)
    {
        displayInput("KO_B-".$i, castKnockout($i, $KO_R));
    }
}

function KO_bestOf($id)
{
    $query = "SELECT T.KO_Rounds, T.seeded_Round
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $KO_R = $data[0][0]; $seeded_R = $data[0][1];


    for($i = 1; $i < $seeded_R; $i++)
    {
	displayInput("KO_B-$i", "KNOCKOUT - РАУНД $i");
    }
    for($i = $seeded_R; $i <= $KO_R; $i++)
    {
	displayInput("KO_B-$i", castKnockout($i, $KO_R));
    }
}



function displayRounds($id, $bracket)
{
    if($bracket == "D/E")
	DE_rounds($id);
    else if($bracket == "K/O")
	KO_rounds($id);
    else if($bracket == "GroupKO")
    {
	GROUP_rounds($id);
	KO_rounds($id);
    }
}

function DE_rounds($id)
{
    $query = "SELECT T.LOW_Rounds, T.KO_Rounds
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $LOW_R = $data[0][0]; $KO_R = $data[0][1];

    for($i = 1; $i <= $LOW_R; $i++)
    {
	displayInput("LOW_R-$i", "НИЖНЯ СІТКА - РАУНД $i");
    }

    ?><div class="margin-b_30"></div><?php

    for($i = 1; $i <= $KO_R+1; $i++)
    {
        displayInput("KO_R-$i", _castKnockout($i, $KO_R));
    }
}

function KO_rounds($id)
{
    $query = "SELECT T.KO_Rounds, T.seeded_Round
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $KO_R = $data[0][0]; $seeded_R = $data[0][1];


    for($i = 1; $i < $seeded_R; $i++)
    {
	displayInput("KO_R-$i", "KNOCKOUT - РАУНД $i");
    }
    for($i = $seeded_R; $i <= $KO_R+1; $i++)
    {
	displayInput("KO_R-$i", _castKnockout($i, $KO_R));
    }
}

function GROUP_rounds($id)
{
    $query = "SELECT
	T.groupMin, T.groupPlayers, T.nrOfGroups, T.groupProceed
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $grpMin = $data[0][0]; $grpPlrs = $data[0][1];
    $n_grps = $data[0][2]; $grpProceed = $data[0][3];

    $grpMax = $grpMin + ceil( ($grpPlrs % $grpMin) / $n_grps );

    for($i = $grpMax; $i > $grpProceed; $i--)
    {
	displayInput("Group_R-$i", "ГРУПА - МІСЦЕ $i");
    }

    ?><div class="margin-b_30"></div><?php
}


function _castKnockout($i, $KO_R)
{
    if($i == $KO_R)
	return "Фіналіст";
    else if($i == $KO_R+1)
	return "Переможець";
    else
        return "1/".pow(2,$KO_R-$i)." Фіналу";
}

?>
