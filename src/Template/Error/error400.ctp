<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
if (extension_loaded('xdebug')) :
    xdebug_print_function_stack();
endif;

$this->end();
endif;
?>
<!-- okiyoru error -->
<?php $this->layout = 'error_okiyoru';?>

<blockquote>
    <h4><?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>></h4>
</blockquote>
<div>
    <div>
    <p class="center-align">以下のような原因が考えられます。</p>
    <div class="card-panel teal">
        <span class="white-text">
            <ul class="center-align">
                <li>一時的にアクセスできません。</li>
                <li>移動、もしくは削除された可能性があります。</li>
            </ul>
        </span>
    </div>
    </div>
</div>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= h($message) ?>
</p>
