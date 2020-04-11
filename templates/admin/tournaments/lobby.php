
<?php

list($name, $billiard, $details, $league, $bracket) =
    getFullName($tournamentID);

tournamentHeader($name, $billiard, $details, $league);



if( !strcmp($status, "Announced") )
	announcedLobby($tournamentID, $onClick);

else if( !strcmp($status, "Registration") )
	registrationLobby($tournamentID, $onClick);

else if( !strcmp($status, "Standby") )
	standbyLobby($tournamentID, $onClick, $bracket);

// add live tournament handler
//else if( !strcmp($status, "Live") )
//	liveLobby($tournamentID, $onClick, $bracket);

else
	redirect(PATH_H."logout.php");


function tournamentHeader($name, $billiard, $details, $league)
{ ?>
<script type="text/javascript" src="<?=PATH_H?>js/tourn_header_highlight.js">
</script>
    <div class="tour_menu_box">
        <div class="tournament_header">
            <div class="nameOf_tour">
                <div class="name_icon">
			<i class="fas fa-trophy"></i>
                	<span style="margin-left:5px;"><?=$name?></span>
            	</div>
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
	require("navigations/announced.php");


//lobby block to show data
	?><div class="sub-container"><?php


//show appropriate data
        if( !strcmp($onClick, "participants") )
                require("lobbyDetails/registeredPlayersListSmall.php");
        else if( !strcmp($onClick, "description") )
                require("lobbyDetails/description.php");
        else
                redirect("");


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
		require("lobbyDetails/registeredPlayersListSmall.php");
	else if( !strcmp($onClick, "register") ) {
		require("lobbyDetails/playerRegisterForm.php");
		require("lobbyDetails/registrationPlayersList.php");
	}	
        else if( !strcmp($onClick, "description") )
                require("lobbyDetails/description.php");
	else
		redirect("");


//close lobby block
	?></div><?php
}

function standbyLobby($tournamentID, $onClick, $bracket)
{
//lobby block to show data
	?><div class="sub-container"><?php

	if( !nonEmpty($bracket) )
		displayStandbyBracket($tournamentID, $onClick);
	else
		displayStandbyRounds($tournamentID, $onClick,$bracket);



//close lobby block
	?></div><?php
}



function displayStandbyBracket($tournamentID, $onClick)
{
//lobby navigation
	require("navigations/header.php");
	require("navigations/standbyBracket.php");
	require("navigations/footer.php");


//show appropriate data
	if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersListSeed.php");
        else if( !strcmp($onClick, "description") )
                require("lobbyDetails/description.php");
	else if( !strcmp($onClick, "KO") )
		require("forms/KO.php");
	else if( !strcmp($onClick, "DE") )
		require("forms/DE.php");
	else if( !strcmp($onClick, "GR-KO") )
		require("forms/GR-KO.php");
	else
		redirect(PATH_H."logout.php");
}


function displayStandbyRounds($tournamentID, $onClick, $bracket)
{
//lobby navigation
	require("navigations/header.php");
	require("navigations/standbyRounds.php");
	require("navigations/footer.php");


//show appropriate data
	if( !strcmp($onClick, "participants") )
		require("lobbyDetails/registeredPlayersListSmall.php");
        else if( !strcmp($onClick, "description") )
                require("lobbyDetails/description.php");
	else if( !strcmp($onClick, "rounds") )
		require("forms/rounds.php");
	else
		redirect(PATH_H."logout.php");
}


function liveLobby($tournamentID, $onClick, $bracket)
{
//lobby navigation
	require("navigations/header.php");

        if( !strcmp($bracket, "GroupKO") )
                require("navigations/groupsKOLive.php");
        else if( !strcmp($bracket, "K/O") || !strcmp($bracket, "D/E") )
                require("navigations/eliminationsLive.php");
        else
                redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=default");

	require("navigations/footer.php");


//lobby block to show data
        $isBracket = ($onClick=="bracket") ? " width_100" : "";
        ?><div class="sub-container<?=$isBracket?>"><?php


//show appropriate data
//	if( !strcmp($onClick, "bracket") )
//		require("lobbyDetails/bracket.php");
//        else if( !strcmp($onClick, "groups") )
//                require("lobbyDetails/groups.php");
        if( !strcmp($onClick, "description") )
                require("lobbyDetails/description.php");
//        else if( !strcmp($onClick, "participants") )
//                require("lobbyDetails/registeredPlayersList.php");
	else
                redirect(PATH_H."tournaments/lobby.php?id=$tournamentID&onClick=description");


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
