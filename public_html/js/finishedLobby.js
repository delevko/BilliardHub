
var tableID;
var item = {
	"action" : "",
	"tableID" : -1
}

$(document).ready(function() {
	item.tableID = getTableID();
});


function getTableID()
{
    _href = document.location.href ? document.location.href : document.location;

    var suffix = _href.split('?');
    var args = suffix[suffix.length-1].split('&');
    var tableID = args[0].split('=');

    return tableID[1];
}


var successHandler = function(data, status) {
	var res = JSON.parse(data); 
	console.log(res);
};

$(function() {
    $('html').keydown(function(event) {
        if(event.which == 13) { // enter
			item.action = "nextMatch";
            $.ajax({
				type: "POST",
				url: "liveQueries/finished.php", 
				data: item,
				success: successHandler, 
            });
			location = location;
        }
        
		else if(event.which == 27) { // ESC
			item.action = "exitMatch";
            $.ajax({
				type: "POST",
				url: "liveQueries/finished.php", 
				data: item,
				success: successHandler, 
            });
			location = location;
        }
    });
});

