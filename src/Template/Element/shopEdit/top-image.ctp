<div id="top-image" class="col s12">
  <?php echo $this->Flash->render(); ?>
  <p>トップ画像<span><a href="" data-target="modal-help" data-help="0" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-top-image" style="text-align:center">
    <img width="100%" height="300" src="<?= $shop->top_image ?>" />
    <button type="button" class="waves-effect waves-light btn-large top-image-changeBtn">変更</button>
  </div>
  <form id="save-top-image" name="save_top_image" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/owner/shops/save_top_image?shop_id=<?= $shop->id ?>" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
    </div>
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file" id="top-image-file" name="top_image_file" onChange="imgDisp();">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" name="top_image" type="text">
      </div>
    </div>
    <img src="" id="top-image-show" />
    <img src="" id="top-image-preview" class="top-image-preview" style="display:none;" />
    <canvas id="top-image-canvas" style="display:none;"></canvas>
    <div class="card-content" style="text-align:center;">
      <button type="button" class="waves-effect waves-light btn-large top-image-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large top-image-saveBtn">更新</button>
    </div>
  </form>
</div>