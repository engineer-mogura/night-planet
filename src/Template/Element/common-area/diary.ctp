<?= $this->element('modal/viewDiaryModal'); ?>
<div id="diary" class="container">
    <?= $this->Flash->render() ?>
    <?= $this->element('nav-breadcrumb'); ?>
    <div class="row">
        <div id="cast-main" class="col s12 m12 l8">
            <div style="display:none;">
                <input type="hidden" name="cast_dir" value="<?=$userInfo['diary_path']?>">
            </div>
            <span id="dummy" style="display: hidden;"></span>
                <div class="row">
                    <form id="view-archive-diary" name="view_archive_diary" method="get" style="display:none;" action="<?=DS.$shopInfo['area']['path'].DS.'view_diary'.DS?>">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="id" value="<?=$castInfo['id']?>">
                        <input type="hidden" name="diary_id" value="">
                    </form>
                    <div class="col s12 m12 l12 xl12">
                    <?php if(count($top_diarys) > 0) { ?>
                        <ul class="collection z-depth-3">
                            <?php foreach ($top_diarys as $key => $row): ?>
                                <li class="linkbox collection-item avatar">
                                    <div class="archiveLink">
                                        <input type="hidden" name="diary_id" value=<?=$row->id?>>
                                        <?php !empty($row['gallery'][0]['file_path'])? $imgPath = $row['gallery'][0]['file_path'] : $imgPath = PATH_ROOT['NO_IMAGE01']; ?>
                                        <img src="<?= $imgPath ?>" alt="" class="circle">
                                        <h6 class="li-linkbox__a__h6"><?=$row->created->nice()?>
                                            <a class="li-linkbox__a-image btn-floating btn red darken-3 lighten-1"><i class="material-icons">camera_alt</i></a>
                                            <span class="li-linkbox__a-image__count"><?=$row->gallery_count?></span>
                                        </h6></br>
                                        <span class="truncate"><?= $row['title'] ?><br><?= $row['content'] ?></span>
                                        <?=$this->User->get_favo_html('new_info_favo_disable', $row)?>
                                        <a class="waves-effect hoverable" href="#"></a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php } ?>
                    <?php
                    ?>
                    <?php if(count($arcive_diarys) > 0) { ?>
                        <ul class="collapsible popout" data-collapsible="accordion">
                            <?php foreach ($arcive_diarys as $rows): ?>
                            <li class="collection-item">
                                <div class="collapsible-header waves-effect"><?= $rows[0]["ym_created"] ?><span class="badge">投稿：<?= count($rows) ?></span></div>
                                <?php foreach ($rows as $row): ?>
                                <?php !empty($row['gallery'][0]['file_path'])? $imgPath = $row['gallery'][0]['file_path'] : $imgPath = PATH_ROOT['NO_IMAGE01']; ?>
                                <div class="linkbox collapsible-body">
                                    <a class="li-linkbox__a-favorite btn-floating btn waves-effect waves-light grey lighten-1 modal-trigger" data-target="modal-login">
                                        <i class="material-icons">favorite</i>
                                    </a>
                                    <div class="archiveLink">
                                        <input type="hidden" name="diary_id" value=<?=$row->id?>>
                                        <h6 class="li-linkbox__a__h6"><?=$row->created->nice()?>
                                            <a class="li-linkbox__a-image btn-floating btn red darken-3 lighten-1"><i class="material-icons">camera_alt</i></a>
                                            <span class="li-linkbox__a-image__count"><?=$row->gallery_count?></span>
                                        </h6></br>
                                        <span class="truncate"><?= $row['title'] ?><br><?= $row['content'] ?></span>
                                        <?=$this->User->get_favo_html('new_info_favo_disable', $row)?>
                                        <a class="waves-effect hoverable" href="#"></a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php } else { ?>
                        <p>過去の投稿はありません。</p>
                    <?php } ?>
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
<?= $this->element('shop-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->


