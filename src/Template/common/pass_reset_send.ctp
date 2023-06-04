<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $owners
*/
?>
    <?= $this->Flash->render() ?>
    <div class="card or-card">
        <div class="card-image waves-block waves-light">
            <div class="or-form-wrap">
                <h3><?= __(LT['001']) ?></h3>
                <?php 
                    if (!empty($owner)) :
                        $email = $owner->email;
                    elseif (!empty($cast)) :
                        $email = $cast->email;
                    endif;
                ?>
                <p><?=$email?>へパスワード再設定メールを送信しました。<br>
                しばらくしてもメールが届かない場合は、スパムフォルダをご確認ください。</p>
                <div class="or-button">
                    <?=$this->Html->link('トップページへ行く','/'
                        ,[ 'class'=>'waves-effect waves-light btn-large']);?>
                </div>
            </div>
        </div>
    </div>