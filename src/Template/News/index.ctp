<div id="news" class="container">
    <?= $this->Flash->render() ?>
    <?= $this->element('nav-breadcrumb'); ?>
    <div class="row">
        <div class="col s12 m12 l8">
            <div class="col s12">
                <?php foreach ($news as $key1 => $row1): ?>
                    <?php foreach ($row1 as $key2 => $row2): ?>
                        <?php 
                            if (is_countable($row2['gallery']) ? count($row2['gallery']) > 0 : 0) {
                                if (count($row2['gallery']) == 1) :
                                    $grid = "grid1";
                                elseif(count($row2['gallery']) == 2):
                                    $grid = "grid2";
                                elseif(count($row2['gallery']) >= 3):
                                    $grid = "";
                                endif;
                            }
                        ?>
                        <div id="<?=$key2?>" class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-image">
                                        <div style="display: inline-block;margin-bottom:30px;padding:initial;" class="<?=$grid?> my-gallery col s12">
                                            <?php
                                                if (is_countable($row2['gallery']) ? count($row2['gallery']) > 0 : 0) {
                                                    foreach ($row2['gallery'] as $key3 => $gallery):
                                            ?>
                                                    <figure>
                                                        <a href="<?=$gallery['file_path']?>" data-size="800x1000">
                                                            <img width="100%" src="<?=$gallery['file_path']?>" alt="<?=$row2->title?>" />
                                                        </a>
                                                        <figcaption style="display:none;">
                                                            <?=$gallery['date']?>
                                                        </figcaption>
                                                    </figure>
                                            <?php
                                                    endforeach;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <p class="right-align"><?=$row2->created->nice()?></p>
                                        <h6 style="margin-top: 20px;font-weight: bold;"><?=$row2->title?></h6>
                                        <p style="margin-top: 20px;"><?=$this->Text->autoParagraph($row2->content)?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <!--デスクトップ用 サイドバー START -->
        <?= $this->element('sidebar'); ?>
        <!--デスクトップ用 サイドバー END -->
    </div>
</div>
<?= $this->element('photoSwipe'); ?>
<!-- ショップ用ボトムナビゲーション START -->
<?= $this->element('shop-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->


