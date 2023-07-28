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
                <p>認証メールをご指定のメールアドレスに送りました。<br>
                １時間以内に完了しないと、やり直しになりますのでご注意ください。<br>
                しばらくしてもメールが届かない場合は、迷惑メールフォルダもご確認ください。</p>
                <div class="or-button">
                    <?=$this->Html->link('トップページへ行く','/'
                        ,[ 'class'=>'waves-effect waves-light btn-large']);?>
                </div>
            </div>
        </div>
    </div>



