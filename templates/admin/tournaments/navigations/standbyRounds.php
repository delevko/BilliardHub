<?php $header = "lobby.php?id=$tournamentID"; ?>

<div class="tour_menu_box">
	<nav class="tour_menu" id="tournament_navigation">
                <a class="icon" onclick="mobileTournamentNav()">
                 <i class="fa fa-bars"></i>&nbsp;Турнірне меню
                 </a>

		<a href="<?=$header?>&onClick=rounds" id="rounds">
			Деталі турніру
		</a>
		
		<a href="<?=$header?>&onClick=participants" id="participants">
			Учасники
		</a>
	</nav>
	<div class="margin-b_30"></div>
</div>
