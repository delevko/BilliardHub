
<?php 


list($name, $billiard, $details, $league, $bracket) = 
	getFullName($tournamentID);

tournamentHeader($name, $billiard, $details, $league, $status,$tournamentID);


if( !strcmp($status, "Announced") )
	announcedLobby($tournamentID, $onClick);

else if( !strcmp($status, "Registration") )
	registrationLobby($tournamentID, $onClick);

else if( !strcmp($status, "Standby") )
	standbyLobby($tournamentID, $onClick);

else if( !strcmp($status,"Live") )
	liveLobby($bracket, $tournamentID, $onClick);

else if( !strcmp($status,"Finished") )
	finishedLobby($bracket, $tournamentID, $onClick);

else
	redirect(PATH_H."tournaments");


function tournamentHeader($name,$billiard,$details,$league,$status,$id)
{ ?>
<script type="text/javascript" src="<?=PATH_H?>js/tourn_header_highlight.js">
</script>
<link rel="stylesheet" type="text/css"
href="<?=PATH_H?>css/tournament_lobby.css">

	<div class="tour_menu_box">
        <div class="tournament_header">
            <div class="nameOf_tour">
                <div class="name_icon">
		    <i class="fas fa-trophy"></i>
                    <span style="margin-left:5px;"><?=$name?></span>
		</div>
		<?php tournRegButtonRender($status, $id); ?>
            </div>

            <div class="second_row">
                <div class="typeOf_tour">
                    <span><?=$billiard?> &nbsp;</span>
                    <span><?=$details?></span>
                </div>
                <div class="organOf_tour">
                    <span><?=$league?></span>
                </div>
            </div>
        </div>

<?php }


function announcedLobby($tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");
	require("navigations/announced.php");
	require("navigations/footer.php");


//lobby block to show data
	?><div class="sub-container"><?php
	

//show appropriate data
	if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersList.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");


//close lobby block
	?></div><?php
}



function registrationLobby($tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");
	require("navigations/registration.php");
	require("navigations/footer.php");


//lobby block to show data
	?><div class="sub-container"><?php


//show appropriate data
	if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersList.php");
	else if( !strcmp($onClick, "description") )
		require("lobbyDetails/description.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=participants");


//close lobby block
	?></div><?php
}



function standbyLobby($tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");
	require("navigations/standby.php");
	require("navigations/footer.php");


//lobby block to show data
	?><div class="sub-container"><?php


//show appropriate data
	if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersList.php");
	else if( !strcmp($onClick, "description") )
		require("lobbyDetails/description.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");


//close lobby block
	?></div><?php
}



function liveLobby($bracket, $tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");

	if( !strcmp($bracket, "Group") )
		require("navigations/groupsLive.php");
	else if( !strcmp($bracket, "GroupKO") )
		require("navigations/groupsKOLive.php");
	else if( !strcmp($bracket, "K/O") || !strcmp($bracket, "D/E") )
		require("navigations/eliminationsLive.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");

	require("navigations/footer.php");


//show appropriate data
        $isBracket = ($onClick=="bracket") ? " width_100" : "";
	?><div class="sub-container<?=$isBracket?>"><?php


	if( !strcmp($onClick, "bracket") )
		require("lobbyDetails/bracket.php");
	else if( !strcmp($onClick, "matches") )
		require("lobbyDetails/matches.php");
	else if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersList.php");
	else if( !strcmp($onClick, "live") )
		require("lobbyDetails/live.php");
	else if( !strcmp($onClick, "groups") ) 
		require("lobbyDetails/groups.php");
	else if( !strcmp($onClick, "groupStanding") ) 
		require("lobbyDetails/groupStanding.php");
	else if( !strcmp($onClick, "breaks") )
		require("lobbyDetails/breaks.php");
	else if( !strcmp($onClick, "matchLobby") )
		require("lobbyDetails/matchLobby.php");
	else if( !strcmp($onClick, "description") )
		require("lobbyDetails/description.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");


//close lobby block
	?></div><?php
}



function finishedLobby($bracket, $tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");

	if( !strcmp($bracket, "Group") )
		require("navigations/groupsFinished.php");
	else if( !strcmp($bracket, "GroupKO") )
		require("navigations/groupsKOFinished.php");
	else if( !strcmp($bracket, "K/O") || !strcmp($bracket, "D/E") )
		require("navigations/eliminationsFinished.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");

	require("navigations/footer.php");
	

//show appropriate data
        $isBracket = ($onClick=="bracket") ? " width_100" : "";
	?><div class="sub-container<?=$isBracket?>"><?php


	if( !strcmp($onClick, "standings") )
		require("lobbyDetails/standings.php");
	else if( !strcmp($onClick, "bracket") )
		require("lobbyDetails/bracket.php");
	else if( !strcmp($onClick, "matches") )
		require("lobbyDetails/matches.php");
	else if( !strcmp($onClick, "groups") )
		require("lobbyDetails/groups.php");
	else if( !strcmp($onClick, "groupStanding") ) 
		require("lobbyDetails/groupStanding.php");
	else if( !strcmp($onClick, "breaks") ) 
		require("lobbyDetails/breaks.php");
	else if( !strcmp($onClick, "matchLobby") )
		require("lobbyDetails/matchLobby.php");
	else if( !strcmp($onClick, "description") )
		require("lobbyDetails/description.php");
	else
		redirect(PATH_H."tournaments/lobby.php?id=$tournamentID");


//close lobby block
	?></div><?php
}

function getFullName($tournamentID)
{
	$query = "SELECT
    T.bracket, B.name AS billiard, A.name AS age, S.name AS sex,
    T.name AS tournament, L.name AS league
FROM tournament T
    JOIN league L ON T.leagueID = L.id
    JOIN age A ON L.ageID = A.id
    JOIN sex S ON L.sexID = S.id
    JOIN billiard B ON L.billiardID = B.id
WHERE T.id=?";

	$data = query($query, $tournamentID); 
	
	$bracket = $data[0][0]; $billiard = $data[0][1];
	$name = $data[0][4]; $league = $data[0][5];

	$details = castDetails($data[0][2], $data[0][3]);
	
	return array($name, $billiard, $details, $league, $bracket);
}

?>
