<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Owner[]|\Cake\Collection\CollectionInterface $owners
*/
?>
<div id="gallery" class="container">
    <?= $this->Flash->render() ?>
    <?= $this->element('nav-breadcrumb'); ?>
    <div class="row">
        <div id="cast-main" class="col s12 m12 l8">
            <div class="row">
                <?= count($gallery) == 0 ? '<p class="col">まだ投稿がありません。</p>': ""; ?>
                <div class="my-gallery" style="display:inline-block;">
                <?php foreach ($gallery as $key => $value): ?>
                    <figure>
                        <a href="<?=$value['file_path']?>" data-size="800x1000">
                        <img width="100%" src="<?=$value['file_path']?>" alt="<?=$value['date']?>" />
                        </a>
                        <figcaption style="display:none;">
                            <?=$value['date']?>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!--デスクトップ用 サイドバー START -->
        <?= $this->element('sidebar'); ?>
        <!--デスクトップ用 サイドバー END -->
    </div>
</div>
<?= $this->element('photoSwipe'); ?>
<!-- ショップ用ボトムナビゲーション START -->
<?= $this->element('cast-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->


