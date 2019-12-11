<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/admin_description.css">

<?php
    $query = "SELECT TD.description FROM tournament_details TD
	WHERE TD.tournamentID=?";
    $data = query($query, $tournamentID);


    displayHeader();

    displayDescription($data[0][0], $tournamentID);

    displayFooter();

function displayDescription($description, $tournamentID)
{ ?>
	<form class="form_reglament" method="POST" action="<?=PATH_H?>admin/tournaments/changeDescription.php">
		<textarea placeholder="Введіть текст.." class="reglament" type="text" maxlength="60000"
		name="description" wrap="soft">
         <?=$description?>
        </textarea>
		<input type="hidden" name="tournamentID" value="<?=$tournamentID?>">
		<button class="b_reglament">
			Змінити
		</button>
	</form>
<?php }

function displayHeader()
{ ?>
    <div class="section_header_700">
        <div class="header_sign">
            <i class="far fa-file-alt"></i>
            Регламент
        </div>
    </div>
<?php }

function displayFooter()
{ ?>
<?php
} ?>

