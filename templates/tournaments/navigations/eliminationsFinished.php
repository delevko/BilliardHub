
<?php $header = "lobby.php?id=$tournamentID"; ?>

	<nav class="tour_menu">
		<a href="<?=$header?>&onClick=standings" id="standings">
			Результати
		</a>
		<a href="<?=$header?>&onClick=bracket" id="bracket">
			Сітка
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
