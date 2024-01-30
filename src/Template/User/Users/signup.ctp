<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $users
*/
?>

    <?= $this->Flash->render() ?>
    <div class="card or-card">
        <div class="card-image waves-block waves-light">
            <div class="or-form-wrap">
                <h3><?= __(LT['001']) ?></h3>
                <?= $this->Form->create($user, array('id' => 'recaptcha-form')) ?>
                <?= $this->Form->control('name', array('label'=>'名前')) ?>
                <?= $this->Form->control('email', array('label'=>'メールアドレス')) ?>
                <div class="message-label">パスワードは大文字小文字を混在させた8文字以上、32文字以内で入力してください。</div>
                <?= $this->Form->control('password', array('label'=>'パスワード')) ?>
                <?= $this->Form->control('password_check', array('type'=>'password','label' => 'パスワード再入力')) ?>
                <?php $options = array('1' => '男', '0' => '女');
                    $attributes = array('legend' => true,'value'=>'1'); ?>
                <?= $this->Form->radio('gender', $options, $attributes); ?>
                <?= $this->Form->input('role', array('type' => 'hidden',
                    'value' => 'user'));?>
                <?= $this->Form->input('recaptcha_token', array('type' => 'hidden', 'value' => ''));?>
                <?= $this->Form->input('recaptcha_action', array('type' => 'hidden', 'value' => ''));?>
                <?= $this->Form->end() ?>
                <?= $this->Form->create() ?>
                    <div class="or-button">
                        <div class="row">
                            <div class="col s6"><?= $this->Form->button('リセット',array('type' =>'reset', 'class'=>'waves-effect waves-light btn-large'));?></div>
                            <div class="col s6"><?= $this->Form->button('登録する',array('type' => 'button'
                                    , 'name' => 'recaptcha_submit'
                                    , 'data-sitekey' => env('GOOGLE_RE_CAPTCHA_KEY', 'not defind!')
                                    , 'data-callback' => 'onSubmit', 'data-action' => 'USER_CREATE_SUBMIT'
                                    , 'class'=>'waves-effect waves-light btn-large g-recaptcha'));?></div>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>



