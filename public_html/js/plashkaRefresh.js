
var tableID, isLeft;

// runs each time the page is loaded
document.addEventListener("DOMContentLoaded", function() {
	tableID = getTableID();

	if( document.getElementById("left").className.includes("highlight") )
		isLeft = true;
	else
		isLeft = false;
});

// helper to get tableID from url
function getTableID()
{
    _href = document.location.href ? document.location.href : document.location;

    var suffix = _href.split('?');
    var args = suffix[suffix.length-1].split('&');
    var tID = args[0].split('=');

    return tID[1];
}

// repeat ajaxRequest every 3 seconds
setInterval(ajaxRequest, 3000);
function ajaxRequest(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'plashka/ajaxPlashka.php?id='+tableID, true);

	xhr.onload = function(){
		if(this.status == 200){
			var res = JSON.parse(this.responseText);
			processResponse(res);
		}
	}

	xhr.onerror = function(){
	}

	xhr.send();
}


function processResponse(res){
	console.log(res);
	var pl1 = document.getElementById('name1').innerHTML;
	var pl2 = document.getElementById('name2').innerHTML;

	var fr1 = document.getElementById('frames1').innerHTML;
	var fr2 = document.getElementById('frames2').innerHTML;

	var pts1 = document.getElementById('points1').innerHTML;
	var pts2 = document.getElementById('points2').innerHTML;

	var b_o = document.getElementById('bestOf').innerHTML;

	if(pl1 != res.name1)
		document.getElementById('name1').innerHTML = res.name1;
	if(pl2 != res.name2)
		document.getElementById('name2').innerHTML = res.name2;

	if(fr1 != res.frames1)
		document.getElementById('frames1').innerHTML = res.frames1;
	if(fr2 != res.frames2)
		document.getElementById('frames2').innerHTML = res.frames2;

	if(pts1 != res.points1)
		document.getElementById('points1').innerHTML = res.points1;
	if(pts2 != res.points2)
		document.getElementById('points2').innerHTML = res.points2;

	if(b_o != res.bestOf)
		document.getElementById('bestOf').innerHTML = res.bestOf;

	if(isLeft && res.break1 == ""){
		document.getElementById('left').className = "plashka_highlight";
		document.getElementById('right').className =
			"plashka_highlight highlight";

		isLeft = false;
	}
	else if(!isLeft && res.break1 != ""){
		document.getElementById('right').className = "plashka_highlight";
		document.getElementById('left').className =
			"plashka_highlight highlight";

		isLeft = true;
	}
}
