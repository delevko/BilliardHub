    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/img_upload.css"> 
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/club_create.css"> 


	<div class="sub-container">
 		<div class="margin-b_30"></div>
        <div class="club_box">
            <div class="club_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="Сlub Logo">
            </div>
            <div class="club_header">
                <span>Додати клуб</span>
            </div>
            <form class="club_form" action="club.php"
			method="post" enctype="multipart/form-data">
                <div class="avatar-upload">
                    <div class="avatar-preview">
                        <div id="clubImg_preview">
                        </div>
                    </div>
                    <div class="avatar-edit">
                        <input type="file" id="clubImg_upload"
						accept=".png, .jpg, .jpeg" name="photo">
                        <label for="clubImg_upload">
							<i class="fas fa-upload"></i>
							Вибрати файл
						</label>
                    </div>
                </div>
                
				<div class="club_data_field">
					<input type="text" name="name"
						autofocus placeholder="Назва">
					<input type="text" name="country"
						placeholder="Країна">
					<input type="text" name="city"
						placeholder="Місто">
					<input type="number" name="tables"
						placeholder="Кількість столів">
 					<div class="margin-b_30"></div>
					
					<button>Додати</button>
                </div>
            </form>
        </div>
	</div>

    <script type="text/javascript" src="<?=PATH_H?>js/img_upload.js">
    </script>

