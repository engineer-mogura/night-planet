<?php
    if (!empty($owner)) :
?>
    <?php
        $url = ADMIN_DOMAIN.'/owner/owners/login/';
    ?>
    <?= $owner->name ?>様。<?= MAIL['FROM_NAME'] ?>です。パスワード変更が完了しました。<br>
        新しいパスワードでログインしてください。<br>
        ログインは以下のURLから<br><br>
<?php
    elseif (!empty($cast)) :
?>
    <?php
        $url = ADMIN_DOMAIN.'/cast/casts/login/';
    ?>
    <?= $cast->name ?>様。<?= MAIL['FROM_NAME'] ?>です。パスワード変更が完了しました。<br>
        新しいパスワードでログインしてください。<br>
        ログインは以下のURLから<br><br>
<?php
    endif;
?>
<span style="color:red;font-weight: bold;">※ URLがリンクになっていない場合、お手数ですが、リンクをコピーし、ブラウザのURL欄に張り付けてください。</span><br><br>
<?= $url ?>