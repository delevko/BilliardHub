
<?php
    $query = "SELECT TD.description FROM tournament_details TD
	WHERE TD.tournamentID=?";
    $data = query($query, $tournamentID);


    displayHeader();

    displayDescription($data[0][0], $tournamentID);

    displayFooter();

function displayDescription($description, $tournamentID)
{ ?>
	<form method="POST" action="<?=PATH_H?>admin/tournaments/changeDescription.php">
		<input type="text" maxlength="60000"
		name="description" value="<?=$description?>">
		<input type="hidden" name="tournamentID" value="<?=$tournamentID?>">
		<button>
			ЗМІНИТИ
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

