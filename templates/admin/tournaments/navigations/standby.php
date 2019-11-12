<?php $header = "lobby.php?id=$tournamentID"; ?>

<div class="tour_menu_box">
	<nav class="tour_menu">
		<a href="<?=$header?>&onClick=KO" id="KO">
			KNOCKOUT
		</a>
		<a href="<?=$header?>&onClick=DE" id="DE">
			DOUBLE ELIMINATION
		</a>
		<a href="<?=$header?>&onClick=GR-KO" id="GR-KO">
			ГРУПИ - KNOCKOUT
		</a>
		
		<a href="<?=$header?>&onClick=participants" id="participants">
			Учасники
		</a>
	</nav>
	<div class="margin-b_30"></div>
</div>
