var SPACE_clicked = false;

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


function sparringLobby() {
    var form = $('<form action="sparring-lobby.php" method="GET">' +
	'<input name="tableID" value="' + tableID + '"/>' + 
	'</form>');

    $('body').append(form);
    form.submit();
}


function refreshLobby() {
    var form = $('<form action="live-match-lobby.php" method="GET">' +
	'<input name="tableID" value="' + tableID + '"/>' + 
	'</form>');

    $('body').append(form);
    form.submit();
}


$(function() {
    $('html').keydown(function(event) {
	if(SPACE_clicked)
	    return;

	// SPACE - start sparring
        if(event.which == 32) {
             SPACE_clicked = true;
             $.confirm({
                title: 'Почати спаринг?',
                boxWidth: '30%',
                useBootstrap: false,
                theme: 'supervan',
                content: '',
                buttons: {
                    confirm: {
                        text: 'TAK - ENTER',
                        keys: ['enter'],
                        action: function() {
	    		    sparringLobby();
                        }
                    },
                    cancel: {
                        text: 'НІ - ESC',
                        keys: ['esc'],
                        action: function() { SPACE_clicked = false; }
                    }
                }
            });
        }

	// ENTER - refresh sparring lobby
        if(event.which == 13) {
		refreshLobby();
	}
    });
});

