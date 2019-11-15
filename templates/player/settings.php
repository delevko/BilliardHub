<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/settings.css">

	<div class="settings_box">
            <div class="settings_header">
                <i class="fas fa-user-cog"></i>
                <span><?=$name?></span>
            </div>


            <div class="toggle_buttons_box">
                <div class="avatar_preview_set">
                        <div id="settingsImg_preview"
			style="background-image:
			url(<?=PATH_H?>img/player/<?=$photo?>);">
                        </div>
                    </div>
                <!-- Change photo -->
                <div class="choose_settings">
                    <div class="change_photo" onclick="settings_buttons('photo');">
                        <span>Змінити фото</span>
                    </div>
                </div>
                <div class="avatar_upload_set" id="photo">
                    <form class="avatar_edit_set" method="post"
		    action="<?=PATH_H?>player/settings.php"
		    enctype="multipart/form-data">
                        <input type="file" id="settingsImg_upload"
			accept=".png, .jpg, .jpeg" name="photo">
                        <label for="settingsImg_upload">
				<i class="fas fa-upload"></i>
				Вибрати файл
			</label>
                        <div class="photo_requirements_set">
                            <span>
                                *Будь ласка, завантажуйте тільки горизонтальне фото.
                            </span>
                        </div>
			<input type="hidden" name="action" value="photo">
			<input type="hidden" name="playerID" value="<?=$playerID?>">
                        <button class="change_button">
				Змінити
			</button>
                    </form>
                </div>

		<!-- Сhange password -->
                <div class="choose_settings">
                    <div class="change_pass" onclick="settings_buttons('pass');">
                        <span>Змінити пароль</span>
                    </div>
                </div>
                <form class="settings_form" method="post" id="pass"
		action="<?=PATH_H?>player/settings.php">
                    <input type="password" name="oldPwd"
			placeholder="Старий пароль">
		    <div class="margin-b_30"></div>

                    <input type="password" name="newPwd1"
			placeholder="Новий пароль">
                    <input type="password" name="newPwd2"
			placeholder="Підтвердіть пароль">

		    <input type="hidden" name="action" value="pwd">
		    <input type="hidden" name="playerID" value="<?=$playerID?>">
                    <button class="change_button">Змінити</button>

                    <div class="forgot_pass">
                        <span></span>
                    </div>
                </form>


            </div>
        </div>

<script type="text/javascript" src="<?=PATH_H?>js/img_upload.js"></script>


<script type="text/javascript">

// BUTTONNS CONTENT
function settings_buttons(id) {
  var x = document.getElementById(id);
  if (x.style.display === "flex") {
    x.style.display = "none";
  } else {
    x.style.display = "flex";
  }
}

</script>

