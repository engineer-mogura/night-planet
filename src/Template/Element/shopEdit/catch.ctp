<div id="catch" class="col s12">
  <?php echo $this->Flash->render(); ?>
  <p>キャッチコピー<span><a href="" data-target="modal-help" data-help="1" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-catch">
    <div class="row">
      <form id="delete-catch" name="delete_catch" method="post" style="display:none;" action="/owner/shops/delete_catch">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="catch" value="">
      </form>
      <div style="display:none;">
        <input type="hidden" name="json_data" value='<?=json_encode(['catch' => $shop->catch]) ?>'>
      </div>
      <?php if(!$shop->catch == "") { ?>
        <div class="row">
          <div class="catch-box center-align col s12 m6 l6">
            <div class="card-panel light-blue accent-1"><?=$this->Text->autoParagraph($shop->catch); ?></div>
          </div>
        </div>
        <div class="card-content center-align">
          <button type="button" class="waves-effect waves-light btn-large catch-changeBtn">変更</button>
          <button type="button" class="waves-effect waves-light btn-large catch-deleteBtn">削除</button>
        </div>
      <?php } else { ?>
        <div class="card-content center-align">
          <p>まだ登録されていません。</p>
          <button type="button" class="waves-effect waves-light btn-large catch-changeBtn">登録</button>
        </div>
     <?php } ?>
    </div>
  </div>
  <form id="save-catch" name="save_catch" method="post" action="/owner/shops/save_catch" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6">
        <textarea id="catch-copy" class="validate materialize-textarea" name="catch" data-length="120"></textarea>
        <label for="cast-copy">キャッチコピー</label>
      </div>
    </div>
    <div class="card-content center-align">
      <button type="button" class="waves-effect waves-light btn-large catch-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large catch-saveBtn">更新</button>
    </div>
  </form>
</div>