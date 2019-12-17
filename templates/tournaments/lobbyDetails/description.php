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

    <!-- <div class="reglament_box">
      <textarea readonly="" class="reglament_text"><?=$description?>
      </textarea>  -->


<textarea data-adaptheight readonly rows="3" cols="40" placeholder="Your input" style="padding: 16px; line-height: 1.5;"><?=$description?></textarea>
<script>
(function() {
    function adjustHeight(textareaElement, minHeight) {
        // compute the height difference which is caused by border and outline
        var outerHeight = parseInt(window.getComputedStyle(el).height, 10);
        var diff = outerHeight - el.clientHeight;

        // set the height to 0 in case of it has to be shrinked
        el.style.height = 0;

        // set the correct height
        // el.scrollHeight is the full height of the content, not just the visible part
        el.style.height = Math.max(minHeight, el.scrollHeight + diff) + 'px';
    }


    // we use the "data-adaptheight" attribute as a marker
    var textAreas = [].slice.call(document.querySelectorAll('textarea[data-adaptheight]'));

    // iterate through all the textareas on the page
    textAreas.forEach(function(el) {

        // we need box-sizing: border-box, if the textarea has padding
        el.style.boxSizing = el.style.mozBoxSizing = 'border-box';

        // we don't need any scrollbars, do we? :)
        el.style.overflowY = 'hidden';

        // the minimum height initiated through the "rows" attribute
        var minHeight = el.scrollHeight;

        el.addEventListener('input', function() {
            adjustHeight(el, minHeight);
        });

        // we have to readjust when window size changes (e.g. orientation change)
        window.addEventListener('resize', function() {
            adjustHeight(el, minHeight);
        });

        // we adjust height to the initial content
        adjustHeight(el, minHeight);

    });
}());
</script>


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

