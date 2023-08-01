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



