<?php
// オーナー認証とユーザー認証を切り分ける。
// ホントはファイルを分けた方が良かった…。
$url = PUBLIC_DOMAIN . '/entry/signup/';
$message = MAIL['FROM_NAME'] . "です。<br>申し訳ございません。何らかの理由により認証に失敗しました。<br>
        もう一度登録し、認証を行ってください。
        <br>もしくは下記メールアドレスにて事務局へご連絡ください。<br>"
  . MAIL['CONTACT_MAIL'];
?>
<div>
  <?= $this->Flash->render(); ?>
  <div class="card or-card">
    <div class="card-image waves-block">
      <div class="card-content" style="text-align:center">
        <p class="right"><?= $message ?></p>
        <br>
        <br>
        <div>
          <a href="<?= $url ?>" class="blue waves-effect waves-light btn"><i class="material-icons left">keyboard_return</i>登録画面に戻る</a>
        </div>
      </div>
    </div>
  </div>
</div>