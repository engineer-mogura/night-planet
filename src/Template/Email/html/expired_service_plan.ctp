<?= $plan->Owners['name'] ?>様。<?= MAIL['FROM_NAME'] ?>です。<br>サービスプランの有効期限が切れました。<br>
<br>
<P>□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■</p>
<p>以下のサービスプランの内容からフリープランへ自動的に変更となりました。ご確認ください。</p>
<p>以前のサービスプラン</p>
<span class="info">【プラン】：<?="【 ".SERVECE_PLAN[$plan->current_plan]['name']." 】"?></span><br>
<span class="info">【コース】：<?="【 ".$plan->course."ヵ月コース 】"?></span><br>
<span class="info">【開始日】：<?="【 ".$this->Time->format($plan->from_start, 'Y/M/d')." 】"?></span><br>
<span class="info">【終了日】：<?="【 ".$this->Time->format($plan->to_end, 'Y/M/d')." 】"?></span>
<p>変更後のサービスプラン</p>
<span class="info">【プラン】：<?="【 ".SERVECE_PLAN[$plan->current_plan]['name']." 】"?></span><br>
<P>□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■</p>
<br>

<P>また、何かわからない事があればこちらのメールへそのままご返信いただければ幸いです。</p>

