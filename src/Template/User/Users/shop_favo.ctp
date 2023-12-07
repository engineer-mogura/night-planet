<div id="myfavo" class="container">
    <?= $this->Flash->render() ?>
    <?= $this->element('nav-breadcrumb'); ?>
    <div class="row">
        <div class="col s12 m12 l8">
            <span id="dummy" style="display: hidden;"></span>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row section favo-list-section">
                        <div class="accent-2 card-panel col s12 center-align">
                            <p class="event-label section-label"><span> お気に入り一覧 </span></p>
                        </div>
                        <div class="col s12 m12 l12">
                            <ul class="collection favo-list-section__ul">
                                <?=$this->element('favo-list')?>
                            </ul>
                            <div class="favo-more-btn-section center-align">
                                <a class="yellow darken-4 waves-effect waves-green btn see_more_favos"
                                     data-type='see_more_favos' data-action=<?=DS.$this->request->url?>>もっと見る
                                </a>
                            </div>
                            <span class="paging" style="float:right"></span>
                        </div>
                    </div>
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
<script>
    var all_favo = '<?php echo ($all_favo); ?>';
    (function (all_favo) {
        var count = $('.favo-list-section__ul__li').length;
        $('.paging').text(count + '/' + all_favo);
    }(all_favo));
</script>