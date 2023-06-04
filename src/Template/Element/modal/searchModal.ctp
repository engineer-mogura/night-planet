<div id="modal-search" class="modal modal-fixed-footer">
  <div class="modal-content">
    <span>選択してキーワードを入力してください</span>
    <div class="row">
      <form method="GET" class="search-form" name="search_form" action="/search/">
        <div class="col s6 m6 l6 modal-search__form__div">
          <p>
            <input type="radio" name="search-choice" id="modal-shop-search" value="shop" <?=($selected['search-choice'] == 'shop')
              || (empty($selected['search-choice'])) ? 'checked':''?> />
            <label for="modal-shop-search">店舗</label>
          </p>
        </div>
        <div class="col s6 m6 l6 modal-search__form__div">
          <p>
            <input type="radio" name="search-choice" id="modal-cast-search" value="cast" <?=$selected['search-choice'] == 'cast' ? 'checked':''?> />
            <label for="modal-cast-search">スタッフ</label>
          </p>
        </div>
        <li class="search col s12 m12 l12">
          <div class="input-field modal-search__input-field">
            <input placeholder="店舗名、スタッフ名を入力" value="<?= $selected['key_word']?>" name="key_word" type="text"
              class="validate input-search">
          </div>
        </li>
        <li class="search col s12 m6 l6 modal-search__form__div">
          <div class="input-field modal-search__input-field">
            <select name="area">
              <option value="" selected>エリアを選択してください。</option>
              <?php foreach ($selectList['area'] as $key => $value): ?>
              <option value="<?=$key?>" <?= $selected['area'] == $key? "selected":"" ?>><?=$value?></option>
              <?php endforeach ?>
            </select>
          </div>
        </li>
        <li class="search col s12 m6 l6 modal-search__form__div">
          <div class="input-field modal-search__input-field">
            <select name="genre">
              <option value="" selected>ジャンルを選択してください。</option>
              <?php foreach ($selectList['genre'] as $key => $value): ?>
              <option value="<?=$key?>" <?= $selected['genre'] == $key? "selected":"" ?>><?=$value?></option>
              <?php endforeach ?>
            </select>
          </div>
        </li>
      </form>
    </div>
  </div>
  <div class="modal-footer">
    <a class="modal-action waves-effect waves-light btn searchBtn" style="width:70%"><i class="material-icons right">search</i>検索</a>
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">閉じる</a>
  </div>
</div>
