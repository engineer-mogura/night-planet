<div id="tenpo" class="col s12">
  <?php echo $this->Flash->render();  ?>
  <p>店舗情報<span><a href="" data-target="modal-help" data-help="4" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-tenpo">
    <div class="row">
      <div class="col s12 m12 l12">
          <div style="display:none;">
            <?php $tenpo = array("name"=>$shop->name, "pref21"=>$shop->pref21, "addr21"=>$shop->addr21,
                              "strt21"=>$shop->strt21, "tel"=>$shop->tel, "bus_from_time"=>$shop->bus_from_time,
                              "bus_to_time"=>$shop->bus_to_time, "bus_hosoku"=>$shop->bus_hosoku,
                              "web_site"=>$shop->web_site, "shop_system"=>$shop->shop_system);?>
            <input type="hidden" name="json_data" value='<?=json_encode($tenpo) ?>'>
            <input type="hidden" name="credit_hidden" value='<?=$masData['credit']?>'>
            <input type="hidden" name="credit_path" value='<?=PATH_ROOT['CREDIT']?>'>
          </div>
          <table class="bordered shop-table z-depth-2" border="1">
          <tr>
            <th align="center">店舗名</th>
            <td><?php if(!$shop->name == '') {
              echo ($shop->name);
            } else {echo ('登録されていません。');}?>
            </td>
          </tr>
          <tr>
            <th align="center">所在地</th>
            <td><?php if(!$shop->full_address == '') {
              echo ($shop->full_address);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">連絡先</th>
            <td><?php if(!$shop->tel == '') {
              echo ($shop->tel);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
          <th align="center">営業時間</th>
            <td><?php if((!empty($shop->bus_from_time))) {
                      $busTime = $this->Time->format($shop->bus_from_time, 'HH:mm')
                      ." ～ ".(empty($shop->bus_to_time) ? 'ラスト' : $this->Time->format($shop->bus_to_time, 'HH:mm'));
                      if (!empty($shop->bus_hosoku)) {
                        $busTime = $busTime.="</br>".$shop->bus_hosoku;
                      }
                      echo (mb_convert_kana($busTime,'N'));
                    } else { echo ('登録されていません。'); } ?>
            </td>
          </tr>
          <tr>
            <th align="center">WEBサイト</th>
            <td><?php if(!$shop->web_site == '') {
              echo ($this->Text->autoParagraph($shop->web_site));
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center" valign="top">システム</th>
            <td><?php if(!$shop->shop_system == '') {
              echo ($this->Text->autoParagraph($shop->shop_system));
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">ご利用できるクレジットカード</th>
            <td><?php if(!$shop->credit == '') { ?>
                <?php $array =explode(',', $shop->credit); ?>
                <?php for ($i = 0; $i < count($array); $i++) { ?>
                <div class="chip-dummy" name="" value="">
                  <img src="<?=PATH_ROOT['CREDIT'] . $array[$i] ?>.png" id="<?=$array[$i]?>" alt="<?=$array[$i]?>">
                  <?=$array[$i]?>
                </div>
                <?php } ?>
                <?php } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
        </table>
        <p style="text-align:center;">
          <button type="button" class="waves-effect waves-light btn-large tenpo-changeBtn">編集</button>
        </p>
      </div>
    </div>
  </div>
  <form id="save-tenpo" name="save_tenpo" method="post" action="/owner/shops/save_tenpo" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="credit" value="">
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="text" class="validate" name="name" data-length="50">
        <label for="name">店舗名</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m12 l12">
        <span>郵便番号からも検索できます。</span>
      </div>
      <div class="input-field col s5 m2 l2">
        <input type="text" id="zip21" name="zip21" size="4" maxlength="3">
        <label for="zip21">郵便番号(3桁)</label>
      </div>
      <div class="col s1 m2 l2 center-align">ー</div>
      <div class="input-field col s6 m2 l2">
        <input type="text" id="zip22" name="zip22" size="5" maxlength="4" onKeyUp="AjaxZip3.zip2addr('zip21','zip22','pref21','addr21','strt21');">
        <label for="zip22">郵便番号(4桁)</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="text" id="pref21" name="pref21" class="validate" size="3">
        <label for="pref21">都道府県</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="text" id="addr21" name="addr21" class="validate" size="10">
        <label for="addr21">市区町村</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="text" id="strt21" name="strt21" class="validate" size="20" data-length="30">
        <label for="strt21">以降の住所</label>
      </div>
    </div>

    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="tel" id="tel" class="validate" name="tel">
        <label for="tel">連絡先 ※ハイフン無しで入力してください。</label>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m12 l12"><label style="font-size: 1rem;">営業時間 ※終了時間は入力無で「LAST」の表示になります。（パソコンからは右クリックで表示します。）</label></div>
      <div class="col s5 m2 l2"><input id="bus-from-time" class="timepicker" name="bus_from_time"></div>
      <div class="col s2 m2 l2 center-align">～</div>
      <div class="col s5 m2 l2"><input id="bus-to-time" class="timepicker" name="bus_to_time"></div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <input type="text" id="bus-hosoku" class="validate" name="bus_hosoku" data-length="50">
        <label for="bus-hosoku">営業時間についての補足</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <textarea id="web_site" class="validate materialize-textarea" name="web_site" data-length="50"></textarea>
        <label for="web_site">WEBサイト</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <textarea id="shop_system" class="validate materialize-textarea" name="shop_system" data-length="900"></textarea>
        <label for="shop_system">システム</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12 ">
        <div class="chips chips-initial disabled" name="credit"></div>
          <label for="chips-autocomplete">クレジットカード</label>
          <span>クレジット一覧から選択してください。</span>
          <div class="card-panel">
            <div class="chip-box">
              <?php foreach ($masCredit as $key => $value): ?>
                <div class="chip-dummy chip-credit" name="" value="">
                  <img src="<?=PATH_ROOT['CREDIT'] . $value->code ?>.png" id="<?=$value->id?>" alt="<?=$value->code?>">
                  <?=$value->code?>
                </div>
              <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card-content" style="text-align:center;">
      <button type="button" href="#" class="waves-effect waves-light btn-large tenpo-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large tenpo-saveBtn">登録</button>
    </div>
  </form>
</div>