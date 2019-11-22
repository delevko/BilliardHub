var ESC_clicked = false;

var tableID;

$(document).ready(function() {
    tableID = getTableID();
});


function getTableID()
{
    _href = document.location.href ? document.location.href : document.location;

    var suffix = _href.split('?');
    var args = suffix[suffix.length-1].split('&');
    var tID = args[0].split('=');

    return tID[1];
}


function tableLobby() {
    var form = $('<form action="live-match-lobby.php" method="GET">' +
	'<input name="tableID" value="' + tableID + '"/>' + 
	'</form>');

    $('body').append(form);
    form.submit();
}


function refreshSparring() {
    var form = $('<form action="sparring-lobby.php" method="GET">' +
	'<input name="tableID" value="' + tableID + '"/>' + 
	'</form>');

    $('body').append(form);
    form.submit();
}

$(function() {
    $('html').keydown(function(event) {
	if(ESC_clicked)
	    return;

	// ESC - open empty table lobby
        if(event.which == 27) {
             ESC_clicked = true;
             $.confirm({
                title: 'Покинути спаринг меню?',
                boxWidth: '30%',
                useBootstrap: false,
                theme: 'supervan',
                content: '',
                buttons: {
                    confirm: {
                        text: 'TAK - ENTER',
                        keys: ['enter'],
                        action: function() {
	    		    tableLobby();
                        }
                    },
                    cancel: {
                        text: 'НІ - ESC',
                        keys: ['esc'],
                        action: function() { ESC_clicked = false; }
                    }
                }
            });
        }

	// ENTER - refresh sparring lobby
        if(event.which == 13) {
		refreshSparring();
	}
    });
});

