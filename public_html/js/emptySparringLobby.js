var ESC_clicked = false;
var focus=1;

var tableID;

$(document).ready(function() {
    tableID = getTableID();

      $('1ID').selectize({
          sortField: 'text'
      });
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

	// SPACE - confirm form input
        else if(event.which == 32) {
		var var1 = document.getElementById("1ID");
		var var2 = document.getElementById("2ID");
		var var3 = document.getElementById("bestOF");

		var player1 = document.getElementById("leftPlayer");
		var player2 = document.getElementById("rightPlayer");
		var middle = document.getElementById("middle");

		if( focus == 1 && var1 && var1.value) {
			var2.focus();
			focus = 2;
    			player1.className = "live-match-lobby-player";
    			player2.className = "live-match-lobby-player highlight";
		}
		else if( focus == 2 && var2 && var2.value) {
			var3.focus();
			focus = 3;
			middle.className = "live-match-lobby-player highlight";
    			player1.className = "live-match-lobby-player";

		       $('2ID').selectize({
	 		  sortField: 'text'
		       });
		}
		else if( focus == 3 && var3 && var3.value) {
			document.getElementById("startForm").submit();
		}
	}

	// ENTER - do nothing
	else if(event.which == 13) {
		return;
        }
    });
});

