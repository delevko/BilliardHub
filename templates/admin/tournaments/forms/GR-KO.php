
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/group_ko.css">

		<div class="margin-b_30"></div>
		<div class="group_ko_box">
            <div class="group_ko_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="group_ko_header">
                <span>ГРУПИ - KNOCKOUT</span>
            </div>
            <form class="group_ko_form" action="start/GR-KO.php"
			method="post">
              <div class="group_ko_select">
                  <select name="seeding">
                    <option selected disabled>Тип сіяння</option>
                    <option value="Standart">Стандарт</option>
                    <option value="Random">Випадковий</option>
                  </select>
              </div>
              <input type="number" name="playersSeeded"
				placeholder="Сіяних гравців">
              <input type="number" name="groupMin"
				placeholder="Гравців у групі">
				<span class="additional_info">
					*Мінімальна кількість
				</span>
              <input type="number" name="proceed"
				placeholder="Виходить з групи">
				<span class="additional_info">
					*(min/2) за замовчуванням
				</span>
		<input type="hidden" name="id"
			value="<?=$tournamentID?>">
              <button>Продовжити</button>
            </form>
        </div>

