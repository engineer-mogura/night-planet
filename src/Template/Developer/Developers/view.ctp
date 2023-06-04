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
                <li class="heading"><?= __('Actions') ?></li>
                <li><?= $this->Html->link(__('開発者リスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Developers']]) ?></li>
                <li><?= $this->Html->link(__('ユーザーリスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Users']]) ?></li>
                <li><?= $this->Html->link(__('オーナーリスト'), ['controller' => 'Developers', 'action' => 'index','?' => ['targetTable'=>'Owners']]) ?></li>
                <li><?= $this->Html->link(__('logout'), ['controller' => 'Developers', 'action' => 'logout']) ?></li>
                <li><?=$this->request->session()->read('Auth.Developer.email')?>でログイン中</li>
            </ul>
        </div>
    </nav>
    <?php if(isset($this->request->query["targetTable"])):?>
        <h3><?= h($itemName1); ?></h3>
        <?php if($itemName2 == "Developers"): ?>
            <h3><?= h($developer->id) ?></h3>
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Email') ?></th>
                    <td><?= h($developer->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Password') ?></th>
                    <td><?= h($developer->password) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($developer->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($developer->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($developer->modified) ?></td>
                </tr>
            </table>
        <?php elseif($itemName2 == "Users"): ?>
            <h3><?= h($user->id) ?></h3>
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
        <?php elseif($itemName2 == "Owners"): ?>
            <h3><?= h($owner->id) ?></h3>
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('Email') ?></th>
                    <td><?= h($owner->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Password') ?></th>
                    <td><?= h($owner->password) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($owner->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($owner->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($owner->modified) ?></td>
                </tr>
            </table>
        <?php endif;?>
    <?php endif;?>
</div>
