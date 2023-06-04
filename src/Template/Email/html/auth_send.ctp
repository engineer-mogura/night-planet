<?php
// オーナー認証とユーザー認証を切り分ける。
// ホントはファイルを分けた方が良かった…。
if (!empty($owner)) :
    $url = ADMIN_DOMAIN . '/owner/owners/verify/' . $owner->tokenGenerate();
    echo($owner->name . "様。初めまして、" . MAIL['FROM_NAME'] . 'です。<br>');
elseif (!empty($cast)) :
    $url = ADMIN_DOMAIN . '/cast/casts/verify/' . $cast->tokenGenerate();
    echo($cast->name . "様。初めまして、" . MAIL['FROM_NAME'] . 'です。<br>');
elseif (!empty($developer)) :
    $url = ADMIN_DOMAIN . '/developer/developer/verify/' . $developer->tokenGenerate();
    echo($developer->name . "様。初めまして、" . MAIL['FROM_NAME'] . 'です。<br>');
elseif (!empty($user)) :
    $url = PUBLIC_DOMAIN . '/user/users/verify/' . $user->tokenGenerate();
    echo($user->name . "様。初めまして、" . MAIL['FROM_NAME'] . 'です。<br>');
endif;

echo('メールアドレスの認証をするために以下のURLにアクセスしてください。<br><br>');
echo('<span style="color:red;font-weight: bold;">※ URLがリンクになっていない場合、お手数ですが、リンクをコピーし、ブラウザのURL欄に張り付けてください。</span><br><br>');

echo($url);