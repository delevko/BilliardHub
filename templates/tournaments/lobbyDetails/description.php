<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/description.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    autosize($('textarea'));
</script>

<?php
    $query = "SELECT TD.description FROM tournament_details TD
	WHERE TD.tournamentID=?";
    $data = query($query, $tournamentID);


    displayHeader();

    displayDescription($data[0][0]);

    displayFooter();

function displayDescription($description)
{ ?>

    <div class="reglament_box">
      <textarea readonly="" class="reglament_text"><?=$description?>
      </textarea> 
    </div>

<?php }


function displayHeader()
{ ?>
    <div class="section_header_700">
        <div class="header_sign">
            <i class="far fa-file-alt"></i>
            Регламент
        </div>
    </div>
<?php
}

function displayFooter()
{ ?>
<?php
} ?>

