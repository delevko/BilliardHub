<html>
<head>
    <title><?=$clubName?>: Стіл <?=$tableNum?></title>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="120;">

    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/live_match_lobby.css"> 

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />



</head>
    <body>
		<div class="container">
		
		<div class="live-match-lobby">
            <a class="live_match_info" href="<?=PATH_H?>admin/clubs/lobby.php?id=<?=$clubID?>">
                <img class="live_logo_img" src="<?=CLUB_IMG.$club_img?>" alt="club logo">
                <span class="live_logo_text">
                    <?=$clubName?>
                </span>
            </a>
            <a class="live-match-lobby-table-num" href="<?=PATH_H?>admin/clubs/tableLobby.php?id=<?=$tableID?>">
        	Стіл #<span><?=$tableNum?></span>
            </a>
        </div>
		<div class="live-match-lobby-table">
			<h3 class="live-match-lobby-info">
			</h3>
			<form class="live-match-lobby-player-table" method="post"
			action="sparringQueries/start.php" id="startForm">
				<input type="hidden" name="tableID" value="<?=$tableID?>"/>
				<div class="live-match-lobby-player highlight" id="leftPlayer">
					<span class="live-match-lobby-player-name">
					    <div class="player_select">
						<select name="1ID" id="1ID"
						autofocus/>
							<option value="">
								Введіть ім'я гравця
							</option>
							<?php displayPlayers(); ?>
						</select>
					    </div>
					</span>
					<p>
						<img class="live-match-lobby-player-img" alt="img" src="<?=PLAYER_IMG?>default.png">
					</p>
				</div>
				<div class="live-match-lobby-frame-section">
					<span id="middle">
						<span class="b_of">BEST OF:</span>
						<input type="number" name="bestOF" id="bestOF"
						placeholder="Best of"/>
					</span>
					<div class="margin-b_50"></div>
					<span class="empty_match_vs">vs</span>
				</div>
				<div class="live-match-lobby-player" id="rightPlayer">
					<span class="live-match-lobby-player-name">
					    <div class="player_select">
						<select name="2ID" id="2ID"/>
							<option value="">
								Введіть ім'я гравця
							</option>
							<?php displayPlayers(); ?>
						</select>
					    </div>
					</span>
					<p>
						<img class="live-match-lobby-player-img" alt="img" src="<?=PLAYER_IMG?>default.png">
					</p>
				</div>
			</form>
<script type="text/javascript" src="<?=PATH_H?>js/emptySparringLobby.js">
</script>
			<div class="button_push">
				<span>
					Натисніть SPACE, щоб підтвердити дію
				</span>
				<span>
					Натисніть ESC, щоб покинути меню
				</span>
			</div>
		</div>
    </body>
</html>

<?php 
function displayPlayers()
{
    $query = "SELECT CONCAT(P.lastName, ' ', P.firstName) AS name, P.id
	FROM player P WHERE id NOT IN(-1, -2) ORDER BY 1";
    $data = query($query);
    $data_count = count($data);

    for($i=0; $i < $data_count; $i++)
    {
	$name = $data[$i][0]; $id = $data[$i][1];
	displayOption($id, $name);
    }
}

function displayOption($id, $value)
{ ?>
	<option value="<?=$id?>"><?=$value?></option>
<?php }
?>
