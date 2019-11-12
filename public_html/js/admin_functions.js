function openClubLobby(ID) {
	window.location.href = ('http://billiardhub.net/admin/clubs/lobby.php?id='+ID);
}
function openTableLobby(ID) {
	window.location.href = ('http://billiardhub.net/admin/clubs/tableLobby.php?id='+ID);
}
function openAdminTournamentLobby(ID) {
	window.location.href = ('http://billiardhub.net/admin/tournaments/lobby.php?id='+ID+'&onClick=default');
}

function admin_panel(evt, tabName) {
    var i, tabcontent, tablinks;

    tabcontent=document.getElementsByClassName("details_anchor");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks=document.getElementsByClassName("highlight_anchor");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" admin_active", "");
    }

    evt.currentTarget.className += " admin_active";
    document.getElementById(tabName).style.display = "block";
}

