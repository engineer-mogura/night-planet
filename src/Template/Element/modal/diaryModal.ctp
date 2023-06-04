<div id="modal-diary" class="modal modal-fixed-footer">
	<div class="modal-content">
		<form id="delete-diary" name="delete_diary" method="post" style="display:none;" action="/cast/casts/delete_diary/">
			<input type="hidden" name="_method" value="POST">
			<input type="hidden" name="id" value="">
			<input type="hidden" name="dir_path" value="">
		</form>
		<!-- モバイル用ボタン START-->
		<div class="right-align fixed-action-btn horizontal click-to-toggle modal-more-horiz show-on-small hide-on-med-and-up">
			<a class="btn-floating red">
				<i class="material-icons">more_horiz</i>
			</a>
			<ul>
				<li>
					<a class="btn-floating red waves-effect waves-light deleteBtn" data-delete="diary">
						<i class="material-icons">delete</i>
					</a>
				</li>
				<li>
					<a class="btn-floating blue waves-effect waves-light updateModeBtn">
						<i class="material-icons">mode_edit</i>
					</a>
					<a class="btn-floating blue waves-effect waves-light returnBtn hide">
						<i class="material-icons">keyboard_return</i>
					</a>
				</li>
			</ul>
		</div>
		<!-- モバイル用ボタン END-->
		<!-- デスクトップ用ボタン START-->
		<div class="right-align hide-on-small-only">
			<a class="red waves-effect waves-light btn deleteBtn" data-delete="diary"><i class="material-icons left">delete</i>削除する</a>
			<a class="blue waves-effect waves-light btn updateModeBtn"><i class="material-icons left">mode_edit</i>編集する</a>
			<a class="blue waves-effect waves-light btn returnBtn hide"><i class="material-icons left">keyboard_return</i>戻る</a>
		</div>
		<!-- デスクトップ用ボタン END-->
		<div>
			<div class="row modal-edit-diary hide">
				<form id="modal-edit-diary" name="modal_edit_diary" method="post" action="/cast/casts/update_diary/">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
						<input type="hidden" name="diary_id" value=''>
						<input type="hidden" name="json_data" value=''>
						<input type="hidden" name="del_list" value="">
						<input type="hidden" name="dir_path" value="">
					</div>
					<div class="row">
						<div class="input-field col s12 m12 l12">
							<input type="text" id="modal-title" class="validate" name="title" value="" data-length="50">
							<label for="title">タイトル</label>
						</div>
						<div class="input-field col s12 m12 l12" style="margin-bottom: 20px;">
							<textarea id="modal-content" class="validate materialize-textarea" name="content" data-length="600"></textarea>
							<label for="content">内容</label>
						</div>
					</div>
					<div class="file-field input-field col s12 m12 l12">
						<div class="btn">
							<span>File</span>
							<input type="file" id="modal-image-file" class="modal-image-file" name="image[]" multiple>
						</div>
						<div class="file-path-wrapper">
							<input id="modal-file-path" class="file-path validate" name="modal_file_path" type="text">
						</div>
						<canvas id="modal-image-canvas" style="display:none;"></canvas>
					</div>
				</form>
			</div>
			<div id="view-diary" class="row">
				<div class="diary-card hide">
					<div class="my-gallery">
						<figure class="col s4 m4 l3 hide">
							<a href="" data-size="800x1000"><img width="100%" src="" alt="写真の説明でーす。" /></a>
						</figure>
					</div>
					<div class="col s12">
						<div class="card-content">
							<p class="created right-align" name="created"></p>
							<p class="title" name="title"></p>
							<p class="content" name="content"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
			<span class="modal-footer__a-favorite btn-floating btn waves-effect waves-light grey lighten-1">
				<i class="material-icons">thumb_up</i>
			</span>
			<span class="modal-footer__a-favorite__count count">0</span>
			<a class="modal-action waves-effect waves-light btn updateBtn disabled"><i class="material-icons right">update</i>更新</a>
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn">閉じる</a>
	</div>
</div>
