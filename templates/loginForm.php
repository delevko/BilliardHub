	
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/login_form.css"> 
		<div class="margin-b_30"></div>
		<div class="login_box">
            <div class="login_img">
                <img src="img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="login_header">
                <span>Вхід</span>
            </div>
            <form class="login_form" action="<?=PATH_H?>login.php" method="post">
              <input type="text" name="username"
				autofocus placeholder="Логін">
              <input type="password" name="password"
			placeholder="Пароль">
              <button>Увійти</button>
            </form>
            
		<a href="<?=PATH_H?>register.php">
			<div class="login_register">
				<span>Зареєструватись</span>
			</div>
		</a>
        </div>

