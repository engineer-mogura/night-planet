<div id="modal-calendar" class="modal">
    <div class="modal-content">
		<h4 class="event-name"></h4>
		<p class="description"></p>
		<div class="modal-box">
			<div class="row">
				<form id="edit-calendar" name="edit_calendar" method="post" action="/cast/casts/edit_calendar/">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
						<input type="hidden" name="crud_type" value="">
						<input type="hidden" name="id" value="">
						<input type="hidden" name="shop_id" value="<?= $castInfo['shop_id'] ?>">
						<input type="hidden" name="cast_id" value="<?= $castInfo['id'] ?>">
						<input type="hidden" name="start" value="">
						<input type="hidden" name="end" value="">
						<input type="hidden" name="all_day" value="">
						<input type="hidden" name="active" value="">
						<input type="hidden" name="calendar_path" value="<?= $calendar_path ?>">
					</div>
					<div class="row">
						<div class="col">
							<label>対象日</label>
							<h5 class="target-day"></h5>
							<p>
								<input type="checkbox" id="all-day" name="all_day" checked="checked" disabled="disabled" />
								<label for="all-day">終日</label>
							</p>
							<label>イベントタイプ</label>
							<ul>
								<?php foreach ($selectList['event'] as $key => $value) {
										echo('<li class="eventlist">');
										if ($value == reset($selectList['event'])) {
										echo('<input type="radio" name="title" id="'.$key.'" value="'.$value.'" checked="checked"/>');
										} else {
										echo('<input type="radio" name="title" id="'.$key.'" value="'.$value.'" />');
										}
										echo('<label for="'.$key.'">'.$value.'</label></li>');
									}
								?>
							</ul>
						</div>
					</div>
					<li class="search col s12 m6 l6">
						<div class="input-field">
							<select id="time-start" name="time_start">
								<option value="" disabled selected>出勤時間を選択してください</option>
								<?php foreach ($selectList['time'] as $key => $value) {
								echo('<option value="' .$value.'">'.$value.'</option>');
								}?>
							</select>
						</div>
					</li>
					<li class="search col s12 m6 l6">
						<div class="input-field">
							<select id="time-end" name="time_end">
								<option value="" disabled selected>退勤時間を選択してください</option>
								<?php foreach ($selectList['time'] as $key => $value) {
								echo('<option value="' .$value.'">'.$value.'</option>');
								}?>
							</select>
						</div>
					</li>
				</form>
			</div>
		</div>
	</div>
    <div class="modal-footer">
      <a class="waves-effect waves-light btn-large createBtn" data-action="create"><i class="material-icons right">save</i>登録</a>
      <a class="waves-effect waves-light btn-large updateBtn" data-action="update"><i class="material-icons right">update</i>更新</a>
      <a class="waves-effect waves-light btn-large deleteBtn" data-action="delete"><i class="material-icons right">delete</i>削除</a>
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
    </div>
  </div>
