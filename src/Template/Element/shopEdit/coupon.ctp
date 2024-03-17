<div id="coupon" class="col s12">
  <?php echo $this->Flash->render();  ?>
  <p>クーポン<span><a href="" data-target="modal-help" data-help="2" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-coupon">
    <div class="row">
      <form id="delete-coupon" name="delete_coupon" method="post" style="display:none;" action="/owner/shops/delete_coupon?shop_id=<?= $shop->id ?>">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="id" value="">
      </form>
      <?php foreach ($shop->coupons as $key => $coupon): ?>
        <div class="col s12 m6 l6 coupon-box">
          <div style="display:none;">
            <input type="hidden" name="json_data" value='<?=$coupon ?>'>
          </div>
          <ul class="collection z-depth-2 <?php if(count($shop->coupons) == $key + 1) { echo('coupon-Scroll');}?>">
            <li class="collection-item">
              <table class="highlight">
                <thead>
                  <tr>
                    <td colspan="2">
                        <span class="coupon-num">クーポン＃<?=$key + 1?></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <img src="<?=PATH_ROOT["COUPON"]?>" alt="" class="circle left" width="50" height="50">
                      <input type="checkbox" class="check-coupon-group" name="check_coupon" id="check-coupon<?=$key?>" />
                      <label for="check-coupon<?=$key?>">編集する</label>
                      <div style="display:none;">
                        <input type="hidden" name="json_data" value='<?=$coupon ?>'>
                      </div>
                      <a href="#!" class="secondary-content">
                        <div class="switch">
                          <label>OFF<input type="checkbox" value="<?=$coupon->status ?>" name="coupon_switch<?=$coupon->id ?>" class="coupon-switchBtn" <?php if ($coupon->status == 1) { echo 'checked'; }?>><span class="lever"></span>ON</label>
                        </div>
                      </a>
                    </td>
                  </tr>
                </thead>
                <tbody class="tbody-coupon-group">
                  <tr><th>有効期間</th>
                    <td><?= $this->Time->format($coupon->from_day, 'Y/M/d') ?>～<?= $this->Time->format($coupon->to_day, 'Y/M/d') ?>
                    </td>
                  </tr>
                  <tr><th>タイトル</th>
                    <td><?=$coupon->title ?></td>
                  </tr>
                  <tr><th>内容</th>
                    <td><?= $this->Text->autoParagraph($coupon->content)?></td>
                  </tr>
                </tbody>
              </table>
            </li>
          </ul>
        </div>
      <?php endforeach; ?>
      <div class="col s12 m12 l12">
        <?php if(count($shop->coupons) == 0) { ?>
            <p>まだ登録されていません。</p>
            <button type="button" class="waves-effect waves-light btn-large coupon-addBtn">登録</button>
        <?php } else { ?>
            <p style="text-align:center;">
              <button type="button" class="waves-effect waves-light btn-large coupon-addBtn">追加</button>
              <button type="button" class="waves-effect waves-light btn-large disabled coupon-changeBtn">変更</button>
              <button type="button" class="waves-effect waves-light btn-large disabled coupon-deleteBtn">削除</button>
            </p>
        <?php } ?>
      </div>
    </div>
  </div>
  <form id="save-coupon" name="save_coupon" method="post" action="/owner/shops/save_coupon?shop_id=<?= $shop->id ?>" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="crud_type" value="">
      <input type="hidden" name="id" value="">
    </div>
    <p>対象期間</p>
    <div class="row">
      <div class="col s5 m4 l3"><input id="from-day" class="datepicker" name="from_day"></div>
      <div class="col s2 m1 l1 center-align">～</div>
      <div class="col s5 m4 l3"><input id="to-day" class="datepicker" name="to_day"></div>
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6">
        <input type="text" id="coupon-title" class="validate" name="title" data-length="50">
        <label for="coupon-title">タイトル</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l6">
        <textarea id="coupon-content" class="validate materialize-textarea" name="content" data-length="255"></textarea>
        <label for="coupon-content">内容</label>
      </div>
    </div>
    <div class="card-content" style="text-align:center;">
      <button type="button" class="waves-effect waves-light btn-large coupon-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large coupon-saveBtn">登録</button>
    </div>
  </form>
</div>