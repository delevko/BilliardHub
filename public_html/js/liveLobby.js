
var ESC_clicked = false;
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
	item.tableID = getTableID();
	
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
    var tableID = args[0].split('=');

    return tableID[1];
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
		url: "liveQueries/live.php", 
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


	$(_break).html( parseInt( $(_break).html() ) - num );
	$(_points).html( parseInt( $(_points).html() ) - num );
	
	item.currPlayer = isLeft;
	item.action = "breakIncrement";
	item.points = -num;
	$.ajax({
		type: "POST",
		url: "liveQueries/live.php", 
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
		url: "liveQueries/live.php", 
		data: item,
		success: successHandler, 
		async: false
	});
}


function finishFrame(leftP, rightP) {
	item.currPlayer = isLeft;
	item.action = "finishFrame";
	$.ajax({
		type: "POST",
		url: "liveQueries/live.php", 
		data: item,
		success: successHandlerFinish, 
		async: false
	});

	location = location;
}


var successHandler = function(data, status) {
	//data = data != "" ? $.parseJSON(data) : {};
	var res = JSON.parse(data); 
	console.log(res);
};


var successHandlerFinish = function(data, status) {
	var res = JSON.parse(data); 
	console.log(res);
	window.location.reload(true)
};


$(function() {
    $('html').keydown(function(event) {
	if(ESC_clicked)
	    return;

	// arrow LEFT - change player
        if(event.which == 37) {

            if( !isLeft ) {
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
		item._break = parseInt( $("#leftBreak").html() );
		breakReset(isLeft);
		isLeft = !isLeft;
		highlight(isLeft);
		changePlayer();
            }
        }


        // arrow UP - break increment
	else if(event.which == 38) {
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
            if( isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
            else if( !isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
        }
        

	// numPad numbers
	else if(event.which >= 97 && event.which <= 103) {
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
		ESC_clicked = true;
		$.confirm({
		    title: 'Завершити фрейм',
		    boxWidth: '30%',
		    useBootstrap: false,
		    theme: 'supervan',
		    content: '',
		    buttons: {
			confirm: {
			    text: 'TAK - ENTER',
			    keys: ['enter'],
			    action: function() {
				if(!isLeft)
					item._break = parseInt( $("#rightBreak").html() );
				else
					item._break = parseInt( $("#leftBreak").html() );
				
				isLeft = !isLeft;
				finishFrame(leftP, rightP);
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
    });
});

