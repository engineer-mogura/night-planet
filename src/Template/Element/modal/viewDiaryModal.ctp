<div id="modal-diary" class="modal modal-fixed-footer">
	<div class="row">
		<div class="modal-content">
			<!-- モバイル用ボタン START-->
			<!-- モバイル用ボタン END-->
			<!-- デスクトップ用ボタン START-->
			<!-- デスクトップ用ボタン END-->
			<div class="diary-card hide">
				<div class="my-gallery">
					<figure class="col s4 m4 l3 hide">
						<a href="" data-size="800x1000"><img width="100%" src="" alt="" /></a>
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
		<div class="modal-footer">
			<div class="favorite">
				<?=$this->User->get_favo_html('modal', (object) array('registry_alias' => 'diarys'))?>
			</div>
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">閉じる</a>
		</div>
	</div>
</div>
