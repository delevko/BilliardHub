
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/rating.css"> 

<?php
	$query = "SELECT
    L.id AS leagueID, L.name AS league, B.name AS billiard,
    A.name AS age, S.name AS sex, count(T.id) AS tournaments
FROM league L
    LEFT JOIN tournament T ON T.leagueID = L.id
    JOIN age A ON L.ageID = A.id
    JOIN sex S ON L.sexID = S.id
    JOIN billiard B ON L.billiardID = B.id
GROUP BY L.id HAVING tournaments > 0 ORDER BY 6 DESC, 2";


	$data = query($query);
	$data_count = count($data);


	leagueHeader();

	for($i=0; $i<$data_count; $i++)
	{
		$leagueID = $data[$i][0]; $leagueName = $data[$i][1];
		$billiard = $data[$i][2]; $age = $data[$i][3];
		$sex = $data[$i][4]; $trnmt_n = $data[$i][5];

		$leagueName .= " ($billiard) ";
		$leagueName .= castDetails($age, $sex);

		$BL = ($i+1 == $data_count) ? " radius_bl" : "";
		$BR = ($i+1 == $data_count) ? " radius_br" : "";
	   
		displayLeague($i+1, $leagueID, $leagueName, $trnmt_n,$BL,$BR);
	}

	leagueFooter();



function displayLeague($i, $id, $name, $trnmt_n, $BL, $BR)
{
	$e_o = ($i%2) ? "odd" : "even";
?>
		<tr onclick="openRating(<?=$id?>);"
		class="tbody_<?=$e_o?> pointer">
			<td class="<?=$e_o?>_num bold<?=$BL?>">
				<?=$i?>
			</td>
			<td>
				<span><?=$name?></span>
			</td>
			<td class="<?=$BR?>">
				<span class="bold"><?=$trnmt_n?></span>
			</td>
		</tr>
<?php }


function leagueHeader()
{ ?>
    <div class="sub-container">
        <div class="section_header_700">
            <div class="header_sign">
				<i class="fas fa-globe-americas"></i>
                Оберіть лігу
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
                    <th>#</th>
                    <th>
			<i class="fas fa-globe-americas"></i>
                        <span>Ліга</span>
                    </th>
                    <th>
			<i class="fas fa-trophy"></i>
                        <span>Кількість турнірів</span>
                    </th>
                </tr>
            </thead>
            <tbody>
<?php
}
function leagueFooter()
{ ?>
            </tbody>
        </table>
        </div>
    </div>
<?php
}


?>

