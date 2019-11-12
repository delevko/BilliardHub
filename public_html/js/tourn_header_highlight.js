function get_tourn_location(_href) {
	var sub_dom = _href.split('/');
	var file_loc = sub_dom[sub_dom.length-1].split('?');

	var args = file_loc[file_loc.length-1].split('=');
	return (args < 2) ? args[0] : args[args.length-1];
}

function set_tourn_highlight()
{
	_href = document.location.href ? document.location.href : document.location;
	
	var _location = get_tourn_location(_href);
	if( document.getElementById(_location) )
		document.getElementById(_location).className = "active";
}

window.onload=function() {
        set_highlight();
        set_tourn_highlight();
}

