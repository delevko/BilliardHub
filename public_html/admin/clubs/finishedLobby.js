
var tableID;
var item = {
	"action" : "",
	"tableID" : -1
}

$(document).ready(function() {
	tableID = $("#tableID").html();
	item.tableID = tableID;

});

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

