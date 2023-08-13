<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>

    <title>
        <?= $this->fetch('title') ?>
    </title>

    <!--メタリスト START -->
    <?= $this->element('heads/meta'); ?>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('materialize.min.css') ?>
    <?= $this->element('heads/css/night-planet'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="entry container">
        <div class="row">
            <div class="col s12">
                <?= $this->Flash->render() ?>
                <div id="header">
                    <?php if($code == 500) :?>
                        <h4><?= __('アクセスしようとしたページは表示できませんでした。') ?></h4>
                    <?php else : ?>
                        <h5><?= __('お探しのページは見つかりませんでした。') ?></h5>
                    <?php endif; ?>
                </div>
                <div>
                    <?= $this->fetch('content') ?>
                </div>
                <div>
                <div class="or-button">
                    <?=$this->Html->link(__('Back'),'javascript:history.back()'
                    ,[ 'class'=>'waves-effect waves-light btn-large']);?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
