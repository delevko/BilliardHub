function player_profile(evt, tabName) {
	var i, tabcontent, tablinks;

	tabcontent=document.getElementsByClassName("details_anchor");	
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	tablinks=document.getElementsByClassName("highlight_anchor");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" pl_pr_active", "");
	}

	evt.currentTarget.className += " pl_pr_active";
	document.getElementById(tabName).style.display = "block";
}

