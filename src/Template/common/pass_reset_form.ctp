<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>

        <title>
            <?= LT['006'] ?>:
            <?= $this->fetch('title') ?>
        </title>

        <!--メタリスト START -->
        <?= $this->element('heads/meta'); ?>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->script('jquery-3.1.0.min.js') ?>
        <?= $this->Html->script('materialize.min.js') ?>
        <?= $this->Html->css('materialize.min.css') ?>
        <?= $this->element('heads/css/night-planet'); ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <?= $this->Flash->render() ?>
        <div class="card or-card">
            <div class="card-image waves-block">
                <div class="or-form-wrap">
                    <h3 class="center-align">
                        <img src="<?=PATH_ROOT['NIGHT_PLANET_LOGO']?>" alt="<?=LT['004']?>" style="width:7em;">
                    </h3>
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



