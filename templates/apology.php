
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/error_page.css">
		<div class="margin-b_30"></div>
		<div class="error_page_box">
            <div class="error_page_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
			<span class="error_page_header">
				Помилка
			</span>
			<span class="error_page_text">
				<?=htmlspecialchars($message)?>
			</span>
            <a href="javascript:history.go(-1);">
				<span class="error_page_register">
					Повернутись
				</span>
			</a>
        </div>

