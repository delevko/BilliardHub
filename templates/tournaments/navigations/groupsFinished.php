
<?php $header = "lobby.php?id=$tournamentID"; ?>

	<nav class="tour_menu" id="tournament_navigation">
                <a class="icon" onclick="mobileTournamentNav()">
                 <i class="fa fa-bars"></i>Турнірне меню
                 </a>

		<a href="<?=$header?>&onClick=standings" id="standings">
			Результати
		</a>
		<a href="<?=$header?>&onClick=groups" id="groups">
			Групи
		</a>
		<a href="<?=$header?>&onClick=matches" id="matches">
			Матчі
		</a>
		<a href="<?=$header?>&onClick=breaks" id="breaks">
			Брейки
		</a>
	</nav>
	<div class="margin-b_30"></div>
</div>

