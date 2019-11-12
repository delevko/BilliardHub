	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
	</script>

<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/register_form.css">
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/img_upload.css"> 

   <div class="margin-b_30"></div>
        <div class="register_box">
            <div class="register_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="register_header">
                <span>Додати гравця</span>
            </div>
            <form class="register_form" method="post"
            action="player.php" enctype="multipart/form-data">
                <div class="avatar-upload">
                    <div class="avatar-preview">
                        <div id="playerImg_preview">
                        </div>
                    </div>
                    <div class="avatar-edit">
                        <input type="file" id="playerImg_upload" accept=".png, .jpg, .jpeg" name="photo">
                        <label for="playerImg_upload">
                            <i class="fas fa-upload"></i>
                            Вибрати файл
                        </label>
                    </div>
                    <div class="photo_requirements">
                        <span>
                            *Будь ласка, завантажуйте тільки горизонтальне фото.
                        </span>
                    </div>
                </div>
				<div class="data_field">
                    <input type="text" name="first"
                        autofocus placeholder="Ім'я">
                    <input type="text" name="last"
                        placeholder="Прізвище">
                    <input type="date" name="birthday">
                    <span class="date_format">
                        *Дата народження
                    </span>
                    <div class="margin-b_30"></div>


                    <input type="text" name="country"
                        placeholder="Країна">
                    <input type="text" name="city"
                        placeholder="Місто">
                    <div class="margin-b_30"></div>


                    <button>Додати</button>
                </div>
			</form>
		</div>

	<script type="text/javascript" src="<?=PATH_H?>js/img_upload.js">
	</script>

