<?php
    if (!empty($owner)) :
?>
    <?php
        $url = ADMIN_DOMAIN.'/owner/owners/reset_verify/'.$owner->tokenGenerate(60);
    ?>
    <?= $owner->name ?>様。<?= MAIL['FROM_NAME'] ?>です。<br>
        パスワードの再設定は以下のURLページより、１時間以内に行ってください。<br><br>
<?php
    elseif (!empty($cast)) :
?>
            <?php
                $url = ADMIN_DOMAIN.'/cast/casts/reset_verify/'.$cast->tokenGenerate(60);
            ?>
            <?= $cast->name ?>様。<?= MAIL['FROM_NAME'] ?>です。<br>
                パスワードの再設定は以下のURLページより、１時間以内に行ってください。<br><br>
<?php
    elseif (!empty($developer)) :
?>
    <?php
        $url = ADMIN_DOMAIN.'/developer/developers/reset_verify/'.'123412341234';
    ?>
    <?= $developer->name ?>様。<?= MAIL['FROM_NAME'] ?>です。<br>
        パスワードの再設定は以下のURLページより、１時間以内に行ってください。<br><br>
<?php
    endif;
?>
<span style="color:red;font-weight: bold;">※ URLがリンクになっていない場合、お手数ですが、リンクをコピーし、ブラウザのURL欄に張り付けてください。</span><br><br>

<?= $url ?>