
<link rel="stylesheet" type="text/css" href="<?=PATH_H?>css/double_elim_form.css">

		<div class="margin-b_30"></div>
		<div class="double_elim_box">
            <div class="double_elim_img">
                <img src="<?=PATH_H?>img/sl_logo.png" alt="BilliardHub Logo">
            </div>
            <div class="double_elim_header">
                <span>DOUBLE ELIMINATION</span>
            </div>
            <form class="double_elim_form" action="start/DE.php"
			method="post">
              <div class="double_elim_select">
                  <select name="seeding">
                    <option selected disabled>Тип сіяння</option>
                    <option value="Standart">Стандарт</option>
                    <option value="Random">Випадковий</option>
                  </select>
              </div>
              <input type="number" name="matches"
				placeholder="Матчів у стадії KNOCKOUT">
			  <input type="hidden" name="id"
				value="<?=$tournamentID?>">
              <button>Старт</button>
            </form>
        </div>

