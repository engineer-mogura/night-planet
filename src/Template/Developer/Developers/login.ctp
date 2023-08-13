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
                    <div class="left">
                        <span>デベロッパログイン</span>
                    </div>
                    <?= $this->Form->create(null, array('class' => 'login')) ?>
                    <?= $this->Form->control('email', array('required' => false)) ?>
                    <?= $this->Form->control('password', array('required' => false)) ?>
                    <?= $this->Form->control('remember_me',['type'=>'checkbox','label'=>['text'=>'ログイン状態を保存する']]) ?>
                    <div class="or-button">
                        <?= $this->Form->button('ログイン',array('class'=>'waves-effect waves-light btn-large'));?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="card-content"style="text-align:center">
                    <p>SNSからでもログインできます。</p>
                    <p><a href="#" class="waves-effect waves-light btn-large disabled">facebook</a>　<a href="#" class="waves-effect waves-light btn-large disabled">twitter</a></p>
                    <br />
                    <p><a href="/developer/developers/pass_reset">パスワードをお忘れですか？</a></p>
                </div>
            </div>
        </div>
    </body>
</html>



