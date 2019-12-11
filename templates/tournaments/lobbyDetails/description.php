<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/description.css">

<?php
    $query = "SELECT TD.description FROM tournament_details TD
	WHERE TD.tournamentID=?";
    $data = query($query, $tournamentID);


    displayHeader();

    displayDescription($data[0][0]);

    displayFooter();

function displayDescription($description)
{ ?>

    <textarea rows="30" readonly class="reglament_text"><?=$description?></textarea> 

     <script>
        
        var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);
             
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}
    </script>

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

