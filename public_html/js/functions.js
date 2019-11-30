function openPlayerLobby(ID) {
	window.location.href = ('http://billiardhub.net/players/lobby.php?id='+ID);
}
function openMatchLobby(tID, mID) {
    window.location.href = ('http://billiardhub.net/tournaments/lobby.php?id=' + tID + 
	'&onClick=matchLobby&matchID=' + mID);
}
function openSparringLobby(mID) {
    window.location.href = ('http://billiardhub.net/players/sparringLobby.php?id=' + mID);
}
function openTournamentLobby(ID) {
	window.location.href = ('http://billiardhub.net/tournaments/lobby.php?id=' + ID + '&onClick=default');
}
function openClubLobby(ID) {
	window.location.href = ('http://billiardhub.net/clubs/lobby.php?id='+ID);
}
function openRating(ID) {
	window.location.href = ('http://billiardhub.net/rankings/ranking.php?id=' + ID);
}
function openYoutube(event, youtube) {
    event.stopPropagation();

    window.location.href=(youtube);
}

