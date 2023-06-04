<div id="shop-sharer-modal" class="modal sharer-modal">
  <div class="modal-content">
    <h5><span class="color-blue"><?=isset($shop) ? $shop->name : $cast->shop->name?></span>をシェアしよう</h5>
    <div class="row">
      <div class="col s6 m6 l3">
        <a class="facebook sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['FACEBOOK'].urlencode($shopInfo['shop_url'])?>">
					<span> Facebook</span>
				</a>
      </div>
      <div class="col s6 m6 l3">
        <a class="twitter sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['TWITTER'].urlencode($shopInfo['shop_url'])?>">
          <span> Twitter</span>
        </a>
      </div>
      <div class="col s6 m6 l3">
        <a class="b_hatena sharer-btn waves-effect waves-light btn-large disabled"><span> はてブ</span></a>
      </div>
      <div class="col s6 m6 l3">
        <a class="line sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['LINE'].urlencode($shopInfo['shop_url'])?>">
					<span> LINE</span>
				</a>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">閉じる</a>
  </div>
</div>