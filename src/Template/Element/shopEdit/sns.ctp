<div id="sns" class="col s12">
  <?php echo $this->Flash->render();  ?>
  <p>SNS<span><a href="" data-target="modal-help" data-help="7" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-sns">
    <div class="row">
      <div class="col s12 m12 l12">
          <div style="display:none;">
            <input type="hidden" name="json_data" value='<?=json_encode($shop->snss[0]) ?>'>
          </div>
          <table class="bordered common-table z-depth-2" border="1">
          <tr>
            <th align="center">facebook</th>
            <td><?php if(!empty($shop->snss[0]->facebook)):
              echo ($shop->snss[0]->facebook);
            else: echo ('登録されていません。');endif;?>
            </td>
          </tr>
          <tr>
            <th align="center">twitter</th>
            <td><?php if(!empty($shop->snss[0]->twitter)):
              echo ($shop->snss[0]->twitter);
            else: echo ('登録されていません。');endif;?>
            </td>
          </tr>
          <tr>
            <th align="center">instagram</th>
            <td><?php if(!empty($shop->snss[0]->instagram)):
              echo ($shop->snss[0]->instagram);
            else: echo ('登録されていません。');endif;?>
            </td>
          </tr>
          <tr>
            <th align="center">line</th>
            <td><?php if(!empty($shop->snss[0]->line)):
              echo ($shop->snss[0]->line);
            else: echo ('登録されていません。');endif;?>
            </td>
          </tr>
        </table>
        <p style="text-align:center;">
          <button type="button" class="waves-effect waves-light btn-large sns-changeBtn">編集</button>
        </p>
      </div>
    </div>
  </div>
  <form id="save-sns" name="save_sns" method="post" action="/owner/shops/save_sns" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="id" value="">
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6 ">
        <input type="text" class="validate" name="facebook" data-length="255">
        <label for="facebook">facebook</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6 ">
        <input type="text" class="validate" name="twitter" data-length="255">
        <label for="twitter">twitter</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6 ">
        <input type="text" class="validate" <?=$ownerInfo['current_plan'] == SERVECE_PLAN['free']['label'] ? ' disabled ' : null ?>name="instagram" data-length="255">
        <label for="instagram">instagram</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m6 l6 ">
        <input type="text" class="validate" disabled name="line" data-length="255">
        <label for="line">line</label>
      </div>
    </div>
    <div class="card-content" style="text-align:center;">
      <button type="button" href="#" class="waves-effect waves-light btn-large sns-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large sns-saveBtn">登録</button>
    </div>
  </form>
</div>