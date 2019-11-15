
<link  rel="stylesheet" type="text/css" href="<?=PATH_H?>css/league_create.css">	
	<div class="sub-container">
		<div class="margin-b_30"></div>
        <div class="league_create_box">
            <div class="league_create_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="league_create_header">
                <span>Додати лігу</span>
            </div>
            <form class="league_create_form" action="league.php" method="post">
                <input type="text" name="name"
			autofocus placeholder="Назва">
		<div class="margin-b_30"></div>

	<?php
		displaySelect("billiard", "Вид більярду");
		displaySelect("age", "Вік");
		displaySelect("organisation", "Організація");
		displaySelect("sex", "Стать");
	?>

              <button>Додати</button>
            </form>
		</div>
	</div>


<?php
function displaySelect($type, $type_ua)
{ ?>
	<div class="league_create_select">
		<select name="<?=$type?>">
			<option selected disabled><?=$type_ua?></option>
			<?php displayOptions($type) ?>
		</select>
	</div>
<?php }


function displayOptions($type)
{
	$query = "SELECT id, name FROM " . $type ." ORDER BY 2";
	$data = query($query);
	$data_count = count($data);

	for($i=0; $i < $data_count; $i++)
	{
		$id = $data[$i][0]; $text = $data[$i][1];
		displayOption($id, $text);
	}
}
function displayOption($id, $text)
{ ?>
			<option value="<?=$id?>"><?=$text?></option>
<?php } ?>

