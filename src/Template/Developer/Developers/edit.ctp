<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Developer $developer
 */
?>
<div class="container">
    <nav>
        <div class="nav-wrapper">
            <ul>
                <li><?= $this->Html->link(__('開発者リスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Developers']]) ?></li>
                <li><?= $this->Html->link(__('ユーザーリスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Users']]) ?></li>
                <li><?= $this->Html->link(__('オーナーリスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Owners']]) ?></li>
                <li><?= $this->Html->link(__('logout'), ['controller' => 'Developers', 'action' => 'logout']) ?></li>
                <li><?=$this->request->session()->read('Auth.Developer.email')?>でログイン中</li>
            </ul>
        </div>
    </nav>
    <div>
    <?php if($itemName2 == "developer"): ?>
    <?= $this->Form->create($developer) ?>
        <p>開発者編集</p>
        <div class="row">
            <?= $this->Form->control('email', array('required' => false)) ?>
            <?= $this->Form->control('password', array('required' => false)) ?>
        </div>
    <?php elseif($itemName2 == "user"): ?>
    <?= $this->Form->create($user) ?>
        <p>ユーザ編集</p>
        <div class="row">
            <?= $this->Form->control('email', array('required' => false)) ?>
            <?= $this->Form->control('password', array('required' => false)) ?>
        </div>
    <?php else: ?>
        <?= $this->Form->create($owner) ?>
        <p>オーナ編集</p>
        <div class="row">
            <?= $this->Form->control('email', array('required' => false)) ?>
            <?= $this->Form->control('password', array('required' => false)) ?>
        </div>
    <?php endif;?>
        <div class="card-content" style="text-align:center;">
            <button type="submit" class="waves-effect waves-light btn-large saveBtn">登録</button>
        </div>
    <?= $this->Form->end() ?>

    </div>
</div>
