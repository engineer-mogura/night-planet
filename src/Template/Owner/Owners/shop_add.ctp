<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $owners
*/
?>
<div id="wrapper">
    <div class="container">
        <?= $this->Flash->render() ?>
        <div class="card or-card">
            <div class="card-image waves-block waves-light">
                <div class="or-form-wrap">
                    <h3><?= __('店舗追加') ?></h3>
                    <?= $this->Form->create($shop) ?>
                    <span>店舗名はいつでも変更可能です。</span>
                    <?= $this->Form->control('name', array('label'=>'店舗名')) ?>
                    <?= $this->Form->input('area', array('type' => 'select',
                                                        'options' => $selectList['area'],
                                                        'empty' => 'エリアを選択してください。',
                                                        'value' => 'エリアを選択してください。',
                                                        'label'=>'エリア')
                                        ); ?>
                    <?= $this->Form->input('genre', array('type' => 'select',
                                                        'options' => $selectList['genre'],
                                                        'empty' => 'ジャンルを選択してください。',
                                                        'value' => 'ジャンルを選択してください。',
                                                        'label'=>'ジャンル')
                                        ); ?>
                    <div class="or-button">
                        <?= $this->Form->button('リセット',array('type' =>'reset', 'class'=>'waves-effect waves-light btn-large'));?>
                        <?= $this->Form->button('登録する',array('type' =>'submit','class'=>'waves-effect waves-light btn-large'));?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>



