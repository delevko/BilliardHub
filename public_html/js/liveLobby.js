
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
	tableID = $("#tableID").html();
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
		success: successHandler, 
		async: false
	});

	location = location;
	//highlight(isLeft);*/
}

var successHandler = function(data, status) {
	var res = JSON.parse(data); 
	console.log(res);
};

$(function() {
    $('html').keydown(function(event) {
        if(event.which == 37) { // <-

            if( !isLeft ) {
				item._break = parseInt( $("#rightBreak").html() );
				breakReset(isLeft);
				isLeft = !isLeft;
				highlight(isLeft);
				changePlayer();
            }
        }

        else if(event.which == 39) { // ->
            if( isLeft ) {
				item._break = parseInt( $("#leftBreak").html() );
				breakReset(isLeft);
				isLeft = !isLeft;
				highlight(isLeft);
				changePlayer();
            }
        }

        else if(event.which >= 49 && event.which <= 55) { // numbers
            if( isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
            else if( !isLeft ) {
                increment(isLeft, event.keyCode-48);
            }
        }

        else if(event.which == 27) { // ESC
            var leftP = parseInt( $("#leftPoints").html() );
            var rightP = parseInt( $("#rightPoints").html() );

            if( leftP != rightP ) {
				if(!isLeft)
					item._break = parseInt( $("#rightBreak").html() );
				else
					item._break = parseInt( $("#leftBreak").html() );
				
				isLeft = !isLeft;
				finishFrame(leftP, rightP);
            }
        }
    });
});

