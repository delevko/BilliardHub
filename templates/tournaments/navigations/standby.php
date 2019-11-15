<?php $header = "lobby.php?id=$tournamentID"; ?>

	<nav class="tour_menu" id="tournament_navigation">
                <a class="icon" onclick="mobileTournamentNav()">
                 <i class="fa fa-bars"></i>Турнірне меню
                 </a>

		<a href="<?=$header?>&onClick=participants" id="participants">
			Учасники
		</a>
	</nav>
	<div class="margin-b_30"></div>
</div>
