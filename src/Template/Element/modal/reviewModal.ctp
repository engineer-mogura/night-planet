<div id="modal-review" class="modal modal-fixed-footer">
  <div class="modal-content">
    <span><?=$shop->name?> のレビュー</span>
	<div class="divider"></div>
	<p></p>
	<div class="row">
		<div class="col s12 center-align">
			<div class="rateit" data-rateit-readonly=true data-rateit-value="5"></div>
			<br><span>かなり良かった</span>
		</div>
	</div>
	<div class="row">
		<div class="col s6 center-align">
			<div class="rateit" data-rateit-readonly=true data-rateit-value="4"></div>
			<br><span>良かった</span>
		</div>
		<div class="col s6 center-align">
			<div class="rateit" data-rateit-readonly=true data-rateit-value="3"></div>
			<br><span>普通</span>
		</div>
	</div>
	<div class="row">
		<div class="col s6 center-align">
			<div class="rateit" data-rateit-readonly=true data-rateit-value="2"></div>
			<br><span>良くなかった</span>
		</div>
		<div class="col s6 center-align">
			<div class="rateit" data-rateit-readonly=true data-rateit-value="1"></div>
			<br><span>かなり良くなかった</span>
		</div>
	</div>
    <div class="row">
	<span>下の５項目の星を選択してね☆</span>
      <form id="review-form" method="GET" class="review-form" name="review_form" action="/user/users/review_send/">
        <div class="card-panel col s12 m12 l12 modal-review__form__div">
			<input type="hidden" name="shop_id" value=<?=$shop->id?>>
			<li class="review col s6 m6 l6">
				<div class="input-field modal-review__input-field">
					<div class="total-review center-align">
						<p class="center-align">コスパ</p>
						<div class="rateit" name="cost"
							data-rateit-value="3"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-step="1">
						</div>
					</div>
				</div>
			</li>
			<li class="review col s6 m6 l6">
				<div class="input-field modal-review__input-field">
					<div class="total-review center-align">
						<p class="center-align">店内雰囲気</p>
						<div class="rateit" name="atmosphere"
							data-rateit-value="3"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-step="1">
						</div>
					</div>
				</div>
			</li>
			<li class="review col s6 m6 l6">
				<div class="input-field modal-review__input-field">
					<div class="total-review center-align">
						<p class="center-align">客層</p>
						<div class="rateit" name="customer"
							data-rateit-value="3"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-step="1">
						</div>
					</div>
				</div>
			</li>
			<li class="review col s6 m6 l6">
				<div class="input-field modal-review__input-field">
					<div class="total-review center-align">
						<p class="center-align">スタッフ</p>
						<div class="rateit" name="staff"
							data-rateit-value="3"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-step="1">
						</div>
					</div>
				</div>
			</li>
			<li class="review col s6 m6 l6">
				<div class="input-field modal-review__input-field">
					<div class="total-review center-align">
						<p class="center-align">清潔感</p>
						<div class="rateit" name="cleanliness"
							data-rateit-value="3"
							data-rateit-min="0"
							data-rateit-max="5"
							data-rateit-step="1">
						</div>
					</div>
				</div>
			</li>
			<div class="divider col s12"></div>
			<li class="review col s12 m12 l12">
				<label for="comment">店舗に何か一言！</label>
				<textarea class="validate materialize-textarea" name="comment" data-length="250"></textarea>
			</li>
		</div>
      </form>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="modal-action waves-effect waves-light btn review_send" style="width:70%"><i class="material-icons right">send</i>送信</button>
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">閉じる</a>
  </div>
</div>
