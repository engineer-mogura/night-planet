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
                <?= $this->Form->create($owner) ?>
                <?= $this->Form->control('name', array('label'=>'名前')) ?>
                <?= $this->Form->control('email', array('label'=>'メールアドレス')) ?>
                <div class="message-label">パスワードは大文字小文字を混在させた8文字以上、32文字以内で入力してください。</div>
                <?= $this->Form->control('password', array('label'=>'パスワード')) ?>
                <?= $this->Form->control('password_check', array('type'=>'password','label' => 'パスワード再入力')) ?>
                <?= $this->Form->control('tel', array('label'=>'電話番号')) ?>
                <?php $options = array('1' => '男', '0' => '女');
                    $attributes = array('legend' => true,'value'=>'1'); ?>
                <?= $this->Form->radio('gender', $options, $attributes); ?>
                <?= $this->Form->input('age', array('type' => 'select',
                    'options' => $selectList['age'],
                    'empty' => '年齢を選択してください。',
                    'value' => '年齢を選択してください。',
                    'label'=>'年齢')
                ); ?>
                <?= $this->Form->input('role', array('type' => 'hidden',
                    'value' => 'owner'));?>
                <div class="or-button">
                    <?= $this->Form->button('リセット',array('type' =>'reset', 'class'=>'waves-effect waves-light btn-large'));?>
                    <?= $this->Form->button('登録する',array('type' =>'submit','class'=>'waves-effect waves-light btn-large'));?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>



