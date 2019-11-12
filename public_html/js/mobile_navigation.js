function mobileHeaderNav() {
	var x = document.getElementById("header_navigation");
	if (x.className === "navigation") {
		x.className += " responsive";
	} else {
		x.className = "navigation";
	}
}

function mobileTournamentNav() {
	var x = document.getElementById("tournament_navigation");
	if (x.className === "tour_menu") {
		x.className += " responsive";
	} else {
		x.className = "tour_menu";
	}
}

