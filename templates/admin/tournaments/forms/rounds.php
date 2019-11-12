<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/rounds_form.css">

		<div class="margin-b_30"></div>
	<div class="rounds_box">
            <div class="rounds_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="rounds_header">
                <span>РАУНДИ TODO</span>
            </div>
	    <form class="rounds_form" method="post"
		action="start/rounds.php">
		<div class="data_field">
		    <?php displayRounds($tournamentID, $bracket); ?>
		</div>
	        <button>Старт</button>
	    </form>
        </div>


<?php

function displayInput($name, $placeholder)
{ ?>
		<input type="number" name="<?=$name?>"
		placeholder="<?=$placeholder?>">
<?php }

function displayRounds($id, $bracket)
{
    if($bracket == "D/E")
	DE_rounds($id);
    else if($bracket == "K/O")
	KO_rounds($id);
    else if($bracket == "GroupKO")
	KO_rounds($id);

}

function DE_rounds()
{
//LOW

//divisor <div class="margin-b_30"></div>

//KO
}

function KO_rounds($id)
{
    $query = "SELECT T.KO_Rounds, T.seeded_Round
	FROM tournament T WHERE T.id=?";
    $data = query($query, $id);
    
    $KO_R = $data[0][0]; $seeded_R = $data[0][1];


    for($i = 1; $i < $seeded_R; $i++)
    {
	displayInput("KO-".$i, "KNOCKOUT - РАУНД ".$i);
    }
    for($i = $seeded_R; $i <= $KO_R+1; $i++)
    {
	displayInput("KO-".$i, _castKnockout($i, $KO_R));
    }
}

function GR_KO_rounds()
{

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
