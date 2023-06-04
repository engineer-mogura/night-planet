<div id="wrapper">
    <div id="shop-edit" class="container">
        <span id="dummy" style="display: hidden;"></span>
        <div class="row">
            <div class="col s12 m12 l12 edit-menu">
                <?= $this->Form->hidden('select_tab',['id'=>'select_tab','value' => $select_tab]); ?>
                <ul class="tabs">
                    <li class="tab"><a class="active" href="#top-image">トップ画像</a></li>
                    <li class="tab"><a href="#catch">キャッチコピー</a></li>
                    <li class="tab"><a href="#coupon">クーポン</a></li>
                    <li class="tab"><a href="#cast">スタッフ</a></li>
                    <li class="tab"><a href="#tenpo">店舗情報</a></li>
                    <li class="tab"><a href="#gallery">店舗ギャラリー</a></li>
                    <li class="tab"><a href="#job">求人情報</a></li>
                    <li class="tab"><a href="#sns">SNS</a></li>
                </ul>
            </div>
            <!-- 編集中の店舗 START-->
            <?= $this->element('now_edit_shop'); ?>
            <!-- 編集中の店舗 END-->
            <!-- トップ画像タブ START-->
            <?= $this->element('shopEdit/top-image'); ?>
            <!-- トップ画像タブ END-->
            <!-- キャッチコピータブ START -->
            <?= $this->element('shopEdit/catch'); ?>
            <!-- キャッチコピータブ END -->
            <!-- クーポンタブ START -->
            <?= $this->element('shopEdit/coupon'); ?>
            <!-- クーポンタブ END -->
            <!-- スタッフタブ START -->
            <?= $this->element('shopEdit/cast'); ?>
            <!-- スタッフタブ END -->
            <!-- 店舗情報タブ START -->
            <?= $this->element('shopEdit/tenpo'); ?>
            <!-- 店舗情報タブ END -->
            <!-- ギャラリータブ START -->
            <?= $this->element('shopEdit/gallery'); ?>
            <!-- ギャラリータブ END -->
            <!-- 求人情報タブ START -->
            <?= $this->element('shopEdit/job'); ?>
            <!-- 求人情報タブ END -->
            <!-- SNSタブ START -->
            <?= $this->element('shopEdit/sns'); ?>
            <!-- SNSタブ END -->
        </div>
    </div>
</div>
<?= $this->element('photoSwipe'); ?>
