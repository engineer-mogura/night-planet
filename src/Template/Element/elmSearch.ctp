<div class="row">
	<form method="GET" class="search-form" name="search_form" action="/search/">
		<div class="col s6 m6 l6">
			<p>
				<input type="radio" name="search-choice" id="shop-search" value="shop" <?=($selected['search-choice'] == 'shop')
					 || (empty($selected['search-choice'])) ? 'checked':''?> />
				<label for="shop-search">店舗</label>
			</p>
		</div>
		<div class="col s6 m6 l6">
			<p>
				<input type="radio" name="search-choice" id="cast-search" value="cast" <?=$selected['search-choice'] == 'cast' ? 'checked':''?> />
				<label for="cast-search">スタッフ</label>
			</p>
		</div>
		<li class="search col s12 m12 l12">
			<div class="input-field">
				<input placeholder="店舗名、スタッフ名を入力" value="<?= $selected['key_word']?>" name="key_word" type="text"
					class="validate input-search">
			</div>
		</li>
		<li class="search col s12 m6 l6">
			<div class="input-field">
				<select name="area">
					<option value="" selected>エリアを選択してください。</option>
					<?php foreach ($selectList['area'] as $key => $value): ?>
					<option value="<?=$key?>" <?= $selected['area'] == $key? "selected":"" ?>><?=$value?></option>
					<?php endforeach ?>
				</select>
			</div>
		</li>
		<li class="search col s12 m6 l6">
			<div class="input-field">
				<select name="genre">
					<option value="" selected>ジャンルを選択してください。</option>
					<?php foreach ($selectList['genre'] as $key => $value): ?>
					<option value="<?=$key?>" <?= $selected['genre'] == $key? "selected":"" ?>><?=$value?></option>
					<?php endforeach ?>
				</select>
			</div>
		</li>
		<li class="search col s12 m12 l12">
			<a class="waves-effect waves-light btn-large searchBtn"><i class="material-icons right">search</i>検索</a>
		</li>
	</form>
</div>