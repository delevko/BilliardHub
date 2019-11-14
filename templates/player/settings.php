<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/settings.css">

	<div class="settings_box">
            <div class="settings_header">
                <i class="fas fa-user"></i>
                <span>Устим Миціка</span>
            </div>


            <div class="toggle_buttons_box">
                <div class="avatar_preview_set">
                        <div id="imagePreview" style="background-image: url(<?=PATH_H?>img/sl_logo.png);">
                        </div>
                    </div>
                <!-- Change photo -->
                <div class="choose_settings">
                    <div class="change_photo" onclick="settings_buttons('photo');">
                        <span>Змінити фото</span>
                    </div>
                </div>
                <div class="avatar_upload_set" id="photo">
                    <div class="avatar_edit_set">
                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"><i class="fas fa-upload"></i> Вибрати файл</label>
                        <div class="photo_requirements_set">
                            <span>
                                *Будь ласка, завантажуйте тільки горизонтальне фото.
                            </span>
                        </div>
                        <button class="change_button">Змінити</button>
                    </div>

                </div>

		<!-- Сhange password -->
                <div class="choose_settings">
                    <div class="change_pass" onclick="settings_buttons('pass');">
                        <span>Змінити пароль</span>
                    </div>
                </div>
                <form class="settings_form" id="pass">
                    <input type="password" placeholder="Старий пароль">
                    <input type="password" placeholder="Новий пароль">
                    <input type="password" placeholder="Підтвердіть пароль">
                    <button class="change_button">Змінити</button>
                    <div class="forgot_pass">
                        <span>Забув пароль?</span>
                    </div>
                </form>


            </div>
        </div>

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



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
</script>

