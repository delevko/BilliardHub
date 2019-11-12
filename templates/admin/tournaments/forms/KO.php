<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/knockout_form.css">

		<div class="margin-b_30"></div>
		<div class="knockout_box">
            <div class="knockout_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="knockout_header">
                <span>Knockout</span>
            </div>
            <form class="knockout_form"
			action="start/KO.php" method="post">
              <div class="knockout_select">
                  <select name="seeding">
                    <option selected disabled>Тип сіяння</option>
                    <option value="Standart">Стандарт</option>
                    <option value="Random">Випадковий</option>
                  </select>
              </div>
              <input type="number" name="playersSeeded"
				placeholder="Сіяних гравців">
		<input type="hidden" name="id" value="<?=$tournamentID?>">
              <button>Продовжити</button>
            </form>
        </div>


