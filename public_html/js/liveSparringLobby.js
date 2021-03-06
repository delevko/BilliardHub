
var ESC_clicked = false;
var BCKSP_clicked = false;
var BTN_clicked = false;
var isLeft, tableID;
var item = {
	"currPlayer": true,
	"action" : "",
	"points" : 0,
	"_break" : 0,
	"tableID" : -1
}


$(document).ready(function() {
	var firstHighlight = document.getElementById("leftPlayer").className;
	tableID = getTableID();
	item.tableID = tableID;
	
	if( firstHighlight.includes("highlight") ) {
		isLeft = true;
		item.currPlayer = true;
	}
	else {
		isLeft = false;
		item.currPlayer = false;
	}
});


function getTableID()
{
    _href = document.location.href ? document.location.href : document.location;

    var suffix = _href.split('?');
    var args = suffix[suffix.length-1].split('&');
    var tID = args[0].split('=');

    return tID[1];
}


function highlight(left) {
    var player1	= (left) ? "leftPlayer" : "rightPlayer";
    var player2	= (left) ? "rightPlayer" : "leftPlayer";

    document.getElementById(player1).className = "live-match-lobby-player highlight";
    document.getElementById(player2).className = "live-match-lobby-player";
}


function breakReset(left) {
    var breakZero = (left) ? "#rightBreak" : "#leftBreak";
	var breakNull = (left) ? "#leftBreak" : "#rightBreak";

	$(breakZero).html(0);
	$(breakNull).html(null);
}


function increment(left, num) {
	var _break = (left) ? "#leftBreak" : "#rightBreak";
	var _points = (left) ? "#leftPoints" : "#rightPoints";
	
	$(_break).html( parseInt( $(_break).html() ) + num );
	$(_points).html( parseInt( $(_points).html() ) + num );
	
	item.currPlayer = isLeft;
	item.action = "breakIncrement";
	item.points = num;
	$.ajax({
		type: "POST",
		url: "sparringQueries/live.php", 
		data: item,
		success: successHandler, 
		async: false
	});
}


function decrement(left, num) {
	var _break = (left) ? "#leftBreak" : "#rightBreak";
	var _points = (left) ? "#leftPoints" : "#rightPoints";

	if( parseInt( $(_break).html() ) - num < 0 )
		return;

	BTN_clicked = true;

	$(_break).html( parseInt( $(_break).html() ) - num );
	$(_points).html( parseInt( $(_points).html() ) - num );
	
	item.currPlayer = isLeft;
	item.action = "breakIncrement";
	item.points = -num;
	$.ajax({
		type: "POST",
		url: "sparringQueries/live.php", 
		data: item,
		success: successHandler, 
		async: false
	});
}


function pointsReset() {
	$("#leftPoints").html(0);
	$("#rightPoints").html(0);

    breakReset(false);
	isLeft = true;
}


function changePlayer() {
	item.currPlayer = isLeft;
	item.action = "changePlayer";
	$.ajax({
		type: "POST",
		url: "sparringQueries/live.php", 
		data: item,
		success: successHandler, 
		async: false
	});
}


function finishFrame(_break) {
    var form = $('<form action="sparringQueries/live.php" method="POST">' + 
	'<input type="hidden" name="action" value="finishFrame"/>' +
	'<input type="hidden" name="tableID" value="' + tableID + '"/>' +
	'<input type="hidden" name="currPlayer" value="' + isLeft + '"/>' +
	'<input type="hidden" name="_break" value="' + _break + '"/>' +
	'</form>');

    $('body').append(form);
    form.submit();
}


function rerack() {
    var form = $('<form action="sparringQueries/live.php" method="POST">' + 
	'<input type="hidden" name="action" value="rerack"/>' +
	'<input type="hidden" name="tableID" value="' + tableID + '"/>' +
	'</form>');

    $('body').append(form);
    form.submit();
}


var successHandler = function(data, status) {
	BTN_clicked = false;
	var res = JSON.parse(data); 
	console.log(res);
};



$(function() {
    $('html').keydown(function(event) {
	if( BTN_clicked || ESC_clicked || BCKSP_clicked )
	    return;

	// arrow LEFT - change player
        if(event.which == 37) {
            if( !isLeft ) {
	        BTN_clicked = true;
		item._break = parseInt( $("#rightBreak").html() );
		breakReset(isLeft);
		isLeft = !isLeft;
		highlight(isLeft);
		changePlayer();
            }
        }


	// arrow RIGHT - change player
        else if(event.which == 39) {
            if( isLeft ) {
	        BTN_clicked = true;
		item._break = parseInt( $("#leftBreak").html() );
		breakReset(isLeft);
		isLeft = !isLeft;
		highlight(isLeft);
		changePlayer();
            }
        }


        // arrow UP - break increment
	else if(event.which == 38) {
	    BTN_clicked = true;
            if( isLeft ) {
                increment(isLeft, 1);
            }
            else if( !isLeft ) {
                increment(isLeft, 1);
            }
	}


        // arrow DOWN - break decrement
	else if(event.which == 40) {
            if( isLeft ) {
                decrement(isLeft, 1);
            }
            else if( !isLeft ) {
                decrement(isLeft, 1);
            }
	}


	// row numbers
        else if(event.which >= 49 && event.which <= 55) {
	    BTN_clicked = true;
            if( isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
            else if( !isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
        }
        

	// numPad numbers
	else if(event.which >= 97 && event.which <= 103) {
	    BTN_clicked = true;
            if( isLeft ) {
                increment(isLeft, event.keyCode-96);
            }
            else if( !isLeft ) {
                increment(isLeft, event.keyCode-96);
            }
        }


	// ESC - finish frame
        else if(event.which == 27) {
            var leftP = parseInt( $("#leftPoints").html() );
            var rightP = parseInt( $("#rightPoints").html() );

            if( leftP != rightP ) {
 	        _content = 'Завершити фрейм з наступним рахунком?';

    	        var name1 = $("#player1").html();
    	        var name2 = $("#player2").html();

	        _title = name1 + '   ' + leftP + ' - ' + rightP + '   ' + name2;
		ESC_clicked = true;

		$.confirm({
		    title: _title,
		    boxWidth: '70%',
		    useBootstrap: false,
		    theme: 'supervan',
		    content: _content,
		    buttons: {
			confirm: {
			    text: 'TAK - ENTER',
			    keys: ['enter'],
			    action: function() {
				var _break;
				if(!isLeft)
					_break = parseInt( $("#rightBreak").html() );
				else
					_break = parseInt( $("#leftBreak").html() );
				
				isLeft = !isLeft;
				finishFrame(_break);
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
        }

	// BACKSPACE - re-rack
        else if(event.which == 8) {
            var leftP = parseInt( $("#leftPoints").html() );
            var rightP = parseInt( $("#rightPoints").html() );

            if( leftP != 0 || rightP != 0 ) {
		var _title = 'Ви бажаєте виконати Re-Rack?';
 	        var _content = 'Всі очки з даного фрейму буде скинуто';
		BCKSP_clicked = true;

		$.confirm({
		    title: _title,
		    boxWidth: '70%',
		    useBootstrap: false,
		    theme: 'supervan',
		    content: _content,
		    buttons: {
			confirm: {
			    text: 'TAK - ENTER',
			    keys: ['enter'],
			    action: function() {
				rerack();
			    }
			},
			cancel: {
			    text: 'НІ - ESC',
			    keys: ['esc'],
			    action: function() {
				BCKSP_clicked = false;
			    }
			}
		    }
		});
            }
        }
    });
});

