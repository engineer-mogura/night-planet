<?php
    if (!empty($owner)) :
        $url = ADMIN_DOMAIN.'/owner/owners/login/';
        echo($owner->name . '様。' . MAIL['FROM_NAME'] .'です。認証が完了しました。<br>
        ログインして、店舗を登録し店舗情報を充実させましょう。<br>');
        echo('ログインは以下のURLから<br><br>');
    elseif (!empty($cast)) :
        $url = ADMIN_DOMAIN.'/cast/casts/login/';
        echo($cast->name . '様。' . MAIL['FROM_NAME'] .'です。認証が完了しました。<br>
        初回ログインパスワードは「pass1234」です。ログイン後はパスワード変更をしてください。<br>');
        echo('ログインは以下のURLから<br><br>');
    elseif (!empty($developer)) :
        $url = ADMIN_DOMAIN.'/developer/developers/login/';
        echo($developer->name . '様。' . MAIL['FROM_NAME'] .'です。認証が完了しました。<br>');
        echo('ログインは以下のURLから<br><br>');
    elseif (!empty($user)) :
        $url = PUBLIC_DOMAIN.'/user/users/login/';
        echo($user->name . '様。' . MAIL['FROM_NAME'] .'です。認証が完了しました。<br>
        ログインして、お気に入りのお店やスタッフを登録して新着情報やスタッフブログを見逃さないようにしよう‼<br>');
        echo('ログインは以下のURLから<br><br>');
    endif;
    echo('<span style="color:red;font-weight: bold;">※ URLがリンクになっていない場合、お手数ですが、リンクをコピーし、ブラウザのURL欄に張り付けてください。</span><br><br>');

    echo($url);