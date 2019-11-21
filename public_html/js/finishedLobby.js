var ESC_clicked = false;
var ENTER_clicked = false;

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


function nextMatch() {
    var form = $('<form action="liveQueries/finished.php" method="POST">' + 
	'<input type="hidden" name="action" value="nextMatch"/>' +
	'<input type="hidden" name="tableID" value="' + tableID + '"/>' +
	'</form>');

    $('body').append(form);
    form.submit();
}


function exitMatch() {
    var form = $('<form action="liveQueries/finished.php" method="POST">' + 
	'<input type="hidden" name="action" value="exitMatch"/>' +
	'<input type="hidden" name="tableID" value="' + tableID + '"/>' +
	'</form>');

    $('body').append(form);
    form.submit();
}


$(function() {
    $('html').keydown(function(event) {
	if(ESC_clicked || ENTER_clicked)
	    return;

	// ENTER - next match
        if(event.which == 13) {
             ENTER_clicked = true;
             $.confirm({
                title: 'Почати наступний матч?',
                boxWidth: '30%',
                useBootstrap: false,
                theme: 'supervan',
                content: '',
                buttons: {
                    confirm: {
                        text: 'TAK - ENTER',
                        keys: ['enter'],
                        action: function() {
	    		    nextMatch();
                        }
                    },
                    cancel: {
                        text: 'НІ - ESC',
                        keys: ['esc'],
                        action: function() { ENTER_clicked = false; }
                    }
                }
            });
        }
        
	// ESC - free table
	else if(event.which == 27) {
             ESC_clicked = true;
             $.confirm({
                title: 'Звільнити стіл?',
                boxWidth: '30%',
                useBootstrap: false,
                theme: 'supervan',
                content: '',
                buttons: {
                    confirm: {
                        text: 'TAK - ENTER',
                        keys: ['enter'],
                        action: function() {
	    		    exitMatch();
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
    });
});

