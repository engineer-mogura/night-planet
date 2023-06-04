<?= $owner->name ?>様。<?= MAIL['FROM_NAME'] ?>です。<br>プランの変更が完了しました。<br>
<br>
<P>□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■</p>
<p>以下、申し込み者情報になります。ご確認ください。</p>
<span class="info">【ID】　　　　　　：<?="【 ".$owner->id." 】"?></span><br>
<span class="info">【お名前】　　　　：<?="【 ".$owner->name." 】"?></span><br>
<span class="info">【TEL】　　　　　：<?="【 ".$owner->tel." 】"?></span><br>
<span class="info">【メールアドレス】：<?="【 ".$owner->email." 】"?></span><br>
<span class="info">【性別】　　　　　：<?=$owner->gender === 1 ? "【 男 】" : "【 女 】" ?></span><br>
<span class="info">【年齢】　　　　　：<?="【 ".$owner->age." 】"?></span><br>
<p>以下、申し込み内容になります。ご確認ください。</p>
<span class="info">【現在のプラン】：<?="【 ".SERVECE_PLAN[$servecePlans->current_plan]['name']." 】"?></span><br>
<span class="info">【コース】　　　：<?="【 ".$servecePlans->course."ヵ月コース 】"?></span><br>
<span class="info">【以前のプラン】：<?="【 ".SERVECE_PLAN[$servecePlans->previous_plan]['name']." 】"?></span><br>
<span class="info">【開始日】　　　：<?="【 ".$this->Time->format($servecePlans->from_start, 'Y/M/d')." 】"?></span><br>
<span class="info">【終了日】　　　：<?="【 ".$this->Time->format($servecePlans->to_end, 'Y/M/d')." 】"?></span>
<P>□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■</p>
<br>
<?php echo('<span>【'.date('Y-m-d', strtotime("+7days")).'】</span>'); ?>までに以下の①、②いずれかの口座までお支払いお願い致します。<br>
<p>※振込指名はご登録頂いているオーナー様の指名で振込をお願いします。</p><br>
<P>----------------------------------------------------------------------------------------------------------------</p>
<span>①</span>
<P>金融機関　　：琉球銀行<br>
    支店名　　　：宮古支店<br>
    支店番号　　：702<br>
    お受取人　　：友利 拓真 TAKUMA TOMORI<br>
    普通口座　　：0316370</p>
<span>②</span>
<P>金融機関　　：ゆうちょ銀行<br>
    支店名　　　：七〇八 店（ナナゼロハチ店）<br>
    店番　　　　：702<br>
    お受取人　　：友利 拓真 TAKUMA TOMORI<br>
    普通口座　　：1944568</p>
<P>----------------------------------------------------------------------------------------------------------------</p>
<P>また、何かわからない事があればこちらのメールへそのままご返信いただければ幸いです。</p>

