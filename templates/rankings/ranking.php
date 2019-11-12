<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/rating.css"> 


<?php
	$query = "SELECT CONCAT(P.firstName,' ',P.lastName) AS player,
	    R.points, R.playerID, P.photo
	    FROM player P
	    INNER JOIN rating R ON P.id = R.playerID
	    WHERE R.leagueID=? ORDER BY 2 DESC, 1";


	$data = query($query, $leagueID);
	$data_count = count($data);

	
	rankingHeader( getLeagueDescription($leagueID) );

	for($i = 0; $i < $data_count; $i++)
	{
		$player = $data[$i][0]; $id = $data[$i][2];
		$pts = $data[$i][1]; $img = $data[$i][3];
		$isLast = ($i+1 == $data_count);

		displayPlayer($i+1, $id, $player, $img, $isLast, $pts);
	}

	rankingFooter();

function getLeagueDescription($id)
{
	$query = "SELECT L.name AS league, B.name AS billiard,
	    A.name AS age, L.sex AS sex
	FROM league L
	    JOIN age A ON L.ageID = A.id
	    JOIN billiard B ON L.billiardID = B.id
	WHERE L.id=?";


	$data = query($query, $id);

	$leagueName = $data[0][0]; $billiard = $data[0][1];
	$age = $data[0][2]; $sex = $data[0][3];

	$leagueText = "$leagueName ($billiard ";
	if( strcmp($age,"") || strcmp($sex,"") )
	{
		$leagueText .= " $age $sex";
	}
	$leagueText .= ")";

	return $leagueText;
}

function displayPlayer($i, $id, $name, $img, $isLast, $pts)
{
    $e_o = ($i%2) ? "odd" : "even";
?>
            <tr onclick="openPlayerLobby(<?=$id?>);"
            class="tbody_<?=$e_o?> pointer">
                <td class="<?=$e_o?>_num<?=($isLast)?" radius_bl":""?> bold">
                    <?=$i?>
                </td>
                <td class="photo_name">
					<img class="circle_img" src="<?=PLAYER_IMG.$img?>" alt="img">
                    <span><?=$name?></span>
                </td>
                <td class="<?=($isLast)?"radius_br":""?>">
                    <?=$pts?>
                </td>
            </tr>
<?php
}


function rankingHeader($hdr)
{ ?>
    <div class="sub-container">
        <div class="section_header_700">
            <div class="header_sign">
				<?=$hdr?>
			</div>
        </div>
        <div class="list_container">
        <table class="list_table_700 rating_table">
            <colgroup>
                <col class="col-1">
                <col class="col-2">
                <col class="col-3">
            </colgroup>
            <thead>
                <tr>
                    <th>
						<i class="fas fa-medal"></i>
					</th>
                    <th>
						<i class="fas fa-user"></i>
                        <span>Гравець</span>
                    </th>
                    <th>
						<i class="fas fa-star"></i>
                        <span>Очки</span>
                    </th>
                </tr>
			</thead>
            <tbody>
<?php
}
function rankingFooter()
{ ?>
            </tbody>
        </table>
        </div>
    </div>
<?php
}
?>

