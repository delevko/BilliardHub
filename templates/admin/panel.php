<?php
require("clubs/index.php");
require("tournaments/index.php");
?>


        <div class="admin_buttons">
            <div class="buttons button_player">
                <span><i class="fas fa-user"></i>
			Додати гравця
		</span>
		<a href="<?=PATH_H?>admin/create/player.php">
			<button>
				<i class="fas fa-user"></i> +
			</button>
		</a>
            </div>
            <div class="buttons button_tour">
                <span><i class="fas fa-trophy"></i>
			Додати турнір
		</span>
		<a href="<?=PATH_H?>admin/create/tournament.php">
                	<button>
				<i class="fas fa-trophy"></i> +
			</button>
		</a>
            </div>
            <div class="buttons button_club">
                <span>
			<i class="fas fa-shield-alt"></i>
			Додати клуб
		</span>
		<a href="<?=PATH_H?>admin/create/club.php">
			<button>
				<i class="fas fa-shield-alt"></i> +
			</button>
		</a>
            </div>
            <div class="buttons button_league">
                <span>
			<i class="fas fa-globe-americas"></i>
			Додати лігу
		</span>
                <a href="<?=PATH_H?>admin/create/league.php">
			<button>
				<i class="fas fa-globe-americas"></i> +
			</button>
		</a>
            </div>
            <div class="buttons button_player">
                <span><i class="fas fa-users"></i>
			Додати організацію
		</span>
		<a href="<?=PATH_H?>admin/create/organisation.php">
			<button>
				<i class="fas fa-users"></i> +
			</button>
		</a>
            </div>
        </div>

        <div class="admin_section02">
            <a class="admin_circle highlight_anchor" href="#tournaments_"
            onclick="admin_panel(event, 'tournaments_')">
                <i class="fas fa-trophy"></i><br>
                <span class="uppercase">турніри</span>
            </a>
            <a class="admin_circle highlight_anchor" href="#clubs_"
            onclick="admin_panel(event, 'clubs_')">
                <i class="fas fa-shield-alt"></i> <br>
                <span class="uppercase">клуби</span>
            </a>
	</div>
	<div class="admin_details">
		<div id="tournaments_" class="details_anchor">
			<?php displayTournaments(); ?>
		</div>

		<div id="clubs_" class="details_anchor">
			<?php displayClubs(); ?>
		</div>
	</div>

