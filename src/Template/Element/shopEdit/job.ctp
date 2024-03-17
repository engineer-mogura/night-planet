<div id="job" class="col s12">
  <?php echo $this->Flash->render();  ?>
  <p>求人情報<span><a href="" data-target="modal-help" data-help="6" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
  <div id="show-job">
    <div class="row">
      <?php foreach ($shop->jobs as $key => $job): ?>
      <div class="col s12 m12 l12">
          <div style="display:none;">
            <input type="hidden" name="json_data" value='<?=$job ?>'>
            <input type="hidden" name="treatment_hidden" value='<?=$masData['treatment']?>'>
          </div>
          <table class="bordered common-table z-depth-2" border="1">
          <tr>
            <th align="center">店舗名</th>
            <td class="show-job-name"><?php if(!empty($shop->name)) {
              echo ($shop->name);
            } else {echo ('登録されていません。');}?>
            </td>
          </tr>
          <tr>
            <th align="center">業種</th>
            <td>
              <?php if(!empty($job->industry)) {
                      echo ($this->Text->autoParagraph($job->industry));
                    } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">職種</th>
            <td>
              <?php if(!empty($job->job_type)) {
                      echo ($this->Text->autoParagraph($job->job_type));
                    } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <th align="center">時間</th>
            <td>
            <?php if(!empty($job->work_from_time)){
                        $workTime = $this->Time->format($job->work_from_time, 'HH:mm')
                        ." ～ ".(empty($job->work_to_time) ? 'ラスト' : $this->Time->format($job->work_to_time, 'HH:mm'));
                        if (!empty($job->work_time_hosoku)) {
                          $workTime = $workTime.="</br>".$job->work_time_hosoku;
                        }
                        echo (mb_convert_kana($workTime,'N'));
                      } else { echo ('登録されていません。'); } ?>
            </td>
          </tr>
          <th align="center">資格</th>
          <td><?php if((!empty($job->from_age))
                      && (!empty($job->to_age))) {
                        $qualification = $job->from_age."歳 ～ ".$job->to_age."歳くらいまで";
                        if (!empty($job->qualification_hosoku)) {
                          $qualification = $qualification.="</br>".$job->qualification_hosoku;
                        }
                        echo (mb_convert_kana($qualification,'N'));
                      } else { echo ('登録されていません。'); } ?>
            </td>
          </tr>
          <th align="center">休日</th>
            <td><?php if(!empty($job->holiday)) {
                        $holiday = $job->holiday;
                        if (!empty($job->holiday_hosoku)) {
                          $holiday = $holiday.="</br>".$job->holiday_hosoku;
                        }
                        echo ($holiday);
                      } else { echo ('登録されていません。'); } ?>
            </td>
          </tr>
            <th align="center">待遇</th>
            <td>
              <?php if(!empty($job->treatment)) { ?>
                <?php $array =explode(',', $job->treatment); ?>
                <?php for ($i = 0; $i < count($array); $i++) { ?>
                <div class="chip-dummy" name=""id="<?=$array[$i]?>" value="<?=$array[$i]?>"><?=$array[$i]?></div>
                </div>
                <?php } ?>
              <?php } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">連絡先1</th>
            <td><?php if(!empty($job->tel1)) {
              echo ($job->tel1);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">連絡先2</th>
            <td><?php if(!empty($job->tel2)) {
              echo ($job->tel2);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">メール</th>
            <td><?php if(!empty($job->email)) {
              echo ($job->email);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">LINEID</th>
            <td><?php if(!empty($job->lineid)) {
              echo ($job->lineid);
            } else {echo ('登録されていません。');} ?>
            </td>
          </tr>
          <tr>
            <th align="center">PR</th>
            <td><?php if(!empty($job->pr)) {
              echo ($this->Text->autoParagraph($job->pr));
            } else {echo ('登録されていません。');}?>
            </td>
          </tr>
        </table>
        <p style="text-align:center;">
          <button type="button" class="waves-effect waves-light btn-large job-changeBtn">編集</button>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <form id="save-job" name="save_job" method="post" action="/owner/shops/save_job?shop_id=<?= $shop->id ?>" style="display:none;">
    <div style="display:none;">
      <input type="hidden" name="_method" value="POST">
      <input type="hidden" name="id" value="">
      <input type="hidden" name="treatment" value="">
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <p name="name"></p>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m5 l6">
      <select name="industry">
          <option value="" disabled selected>業種を選択してください。</option>
          <?php foreach ($selectList['industry'] as $key => $value) {
            echo('<option value="' .$value.'">'.$value.'</option>');
            }?>
        </select>
        <label>業種</label>
      </div>
      <div class="input-field col s12 m5 l6">
      <select name="job_type">
          <option value="" disabled selected>職種を選択してください。</option>
          <?php foreach ($selectList['job_type'] as $key => $value) {
            echo('<option value="' .$value.'">'.$value.'</option>');
            }?>
        </select>
        <label>職種</label>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m12 l12"><label style="font-size: 1rem;">時間※終了時間は入力無で「LAST」の表示になります。（パソコンからは右クリックで表示します。）</label></div>
      <div class="col s5 m2 l2"><input id="work-from-time" class="timepicker" name="work_from_time"></div>
      <div class="col s2 m2 l2 center-align">～</div>
      <div class="col s5 m2 l2"><input id="work-to-time" class="timepicker" name="work_to_time"></div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="text" id="work-time-hosoku" class="validate" name="work_time_hosoku" data-length="50">
        <label for="work-time-hosoku">時間についての補足</label>
      </div>
    </div>
    <div class="row">
    <div class="input-field col s12 m3 l3">
      <select name="from_age">
          <option value="" selected>年齢を選択してください</option>
          <?php foreach ($selectList['age'] as $key => $value) {
            echo('<option value="' .$key.'">'.$value.'</option>');
            }?>
        </select>
        <label>資格</label>
      </div>
      <label class="col s12 m1 l1">歳から</label>
      <div class="input-field col s12 m3 l3">
        <select name="to_age">
          <option value="" selected>年齢を選択してください</option>
          <?php foreach ($selectList['age'] as $key => $value) {
            echo('<option value="' .$key.'">'.$value.'</option>');
            }?>
        </select>
      </div>
      <label class="col s12 m1 l1">歳くらいまで</label>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="text" id="qualification-hosoku" class="validate" name="qualification_hosoku" data-length="50">
        <label for="qualification-hosoku">資格についての補足</label>
      </div>
    </div>
    <div class="row">
      <div class="col s12 m10 l12">
        <label>休日</label>
        <ul>
          <?php foreach ($selectList['day'] as $key => $value) {
                  echo('<li class="daylist"><input type="checkbox" name="holiday[]" id="'.$key.'" value="'.$value.'" /><label for="'.$key.'">'.$value.'</label></li>');
                }
          ?>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="text" id="holiday_hosoku" class="validate" name="holiday_hosoku">
        <label for="holiday_hosoku">休日についての補足</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
      <div class="chips chips-initial disabled" name="credit"></div>
        <label for="chips-autocomplete">待遇</label>
        <a data-target="modal-job" class="waves-effect waves-light btn-large modal-trigger jobModal-callBtn">リストから選ぶ</a>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <textarea id="pr" class="materialize-textarea" name="pr" data-length="400"></textarea>
        <label for="pr">PR文</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="tel" id="tel1" class="validate" name="tel1">
        <label for="tel1">連絡先１</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="tel" id="tel2" class="validate" name="tel2">
        <label for="tel2">連絡先２</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="text" id="email" class="validate" name="email">
        <label for="email">email</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12 m10 l12">
        <input type="text" id="lineid" class="validate" name="lineid">
        <label for="lineid">LINEID</label>
      </div>
    </div>
    <div class="card-content" style="text-align:center;">
      <button type="button" href="#" class="waves-effect waves-light btn-large job-changeBtn">やめる</button>
      <button type="button" class="waves-effect waves-light btn-large job-saveBtn">登録</button>
    </div>
  </form>
</div>