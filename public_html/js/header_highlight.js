function get_location(_href) {
	var arr = _href.split('/');
	return (arr < 2) ? arr[0] : arr[arr.length-2];
}

function set_highlight()
{
	_href = document.location.href ? document.location.href : document.location;
	
	var _location = get_location(_href);
	if( document.getElementById(_location) )
		document.getElementById(_location).className = "active";
}

window.onload=function() {
	set_highlight();
}
