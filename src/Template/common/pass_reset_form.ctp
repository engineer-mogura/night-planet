<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
        <title>
            <?= LT['006'] ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->script('jquery-3.1.0.min.js') ?>
        <?= $this->Html->script('materialize.min.js') ?>
        <?= $this->Html->css('materialize.css') ?>
        <?= $this->Html->css('night-planet.css') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <?= $this->Flash->render() ?>
        <div class="card or-card">
            <div class="card-image waves-block">
                <div class="or-form-wrap">
                    <h3><?= LT['001'] ?></h3>
                    <?php if ($is_reset_form) : ?>
                        <?= $this->Form->create(null, array('class' => 'resetVerify')) ?>
                        <div class="message-label">パスワードは大文字小文字を混在させた8文字以上、32文字以内で入力してください。</div>
                        <?= $this->Form->control('password', array('required' => false)) ?>
                        <div class="or-button">
                            <?= $this->Form->button('パスワード変更',array('class'=>'waves-effect waves-light btn-large'));?>
                        </div>
                        <?= $this->Form->end() ?>
                    <?php else : ?>
                        <div class="left">
                            <div class="message-label">パスワード再設定の為のメールを送信します。<br>
                                ご登録いただいてるメールアドレスを入力してください。</div>
                        </div>
                        <?= $this->Form->create(null, array('class' => 'login')) ?>
                        <?= $this->Form->control('email', array('required' => false)) ?>
                        <div class="or-button">
                            <?= $this->Form->button('送信',array('class'=>'waves-effect waves-light btn-large'));?>
                        </div>
                        <?= $this->Form->end() ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>



