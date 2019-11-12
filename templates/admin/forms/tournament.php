
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/tournament_form.css">

	<div class="sub-container">
		<div class="margin-b_30"></div>
        <div class="login_box">
            <div class="login_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="login_header">
                <span>Додати турнір</span>
            </div>
            <form class="login_form" action="tournament.php" method="post">
            	<input type="text" name="name"
					autofocus placeholder="Назва">
            	<div class="tour_select">
              		<select name="league">
						<option selected disabled> Оберіть лігу</option>
                 		<?php printLeagues(); ?>
					</select>
              	</div>
            	<div class="tour_select">
                  	<select name="club">
                    	<option selected disabled> Оберіть клуб</option>
                  		<?php printClubs(); ?>
					</select>
              	</div>
				<div class="margin-b_30"></div>
              	
				<input type="date" name="begDate">
             	<span class="date_format">
                	*Дата початку турніру
              	</span>
              	<input type="date" name="endDate">
             	<span class="date_format">
                	*Дата завершення турніру
              	</span>
				<div class="margin-b_30"></div>
				
				<button>Додати</button>
			</form>
		</div>
	</div>

<?php
function printLeagues()
{
	$data = query("SELECT L.id AS leagueID, L.name AS league,
		B.name AS billiard, A.name AS age,
		L.sex FROM league L
		JOIN age A ON L.ageID = A.id
		JOIN billiard B ON L.billiardID = B.id
		ORDER BY 2, 3 DESC, 4, 5");
	$data_count = count($data);
	
	for($i=0; $i < $data_count; $i++)
	{
		$leagueID = $data[$i][0]; $leagueName = $data[$i][1];
		$billiard = $data[$i][2]; $age = $data[$i][3];
		$sex = $data[$i][4];
		
		$leagueText = $leagueName."(".$billiard;
		if( $age != "" || $sex != "" )
		{
			$leagueText .= " ".$age." ".$sex;
		}
		$leagueText .= ")";

		displayOption($leagueID, $leagueText);
	}
}

function printClubs()
{
	$data = query("SELECT id, name, city FROM club 
		ORDER by 2, 1");
	for($i=0; $i<count($data); $i++)
	{
		$clubID = $data[$i][0]; $clubName = $data[$i][1];
		$clubCity = $data[$i][2];
		
		displayOption($clubID, $clubName.", ".$clubCity);
	}
}


function displayOption($id, $text)
{ ?>
	<option value="<?=$id?>"><?=$text?></option>
<?php } ?>

