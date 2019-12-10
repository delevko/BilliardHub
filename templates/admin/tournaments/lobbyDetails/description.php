
<?php
    $query = "SELECT TD.description FROM tournament_details TD
	WHERE TD.tournamentID=?";
    $data = query($query, $tournamentID);


    displayHeader();

    displayDescription($data[0][0]);

    displayFooter();


function displayDescription($description)
{ ?>

	<?=$description?>

<?php }


function displayHeader()
{ ?>
    <div class="section_header_700">
        <div class="header_sign">
            <i class="far fa-file-alt"></i>
            Регламент
        </div>
    </div>
    <div class="list_container">
<?php
}

function displayFooter()
{ ?>
    </div>
<?php
} ?>

