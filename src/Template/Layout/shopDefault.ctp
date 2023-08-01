<!DOCTYPE html>
<html>
<head>
  <?= $this->element('analytics_key'); ?>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
  <title>
    <?= LT['004'] ?>:
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('apple-touch-icon-precomposed', '/night_planet_top_favicon.png', [
      'type'=>'icon',
      'size' => '144x144',
      'rel'=>'apple-touch-icon-precomposed'
  ])."\n";?>
  <?= SHOP_NO_INDEX ? $this->Html->meta('robots',['content'=> 'noindex']): "";?>
  <?= NO_FOLLOW ? $this->Html->meta('robots',['content'=> 'nofollow']): "";?>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->script('jquery-3.1.0.min.js') ?>
  <?= $this->Html->script('materialize.min.js') ?>
  <?= $this->Html->script('map.js') ?>
  <?= $this->Html->script('night-planet.js') ?>
  <?= $this->Html->script('ja_JP.js') ?>
  <?= $this->Html->script('jquery.notifyBar.js') ?>
  <?= $this->Html->script('ajaxzip3.js') ?>
  <?= $this->Html->script('moment.min.js') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->script('fullcalendar.min.js') ?><!-- fullcalendar-3.9.0 --><!-- TODO: minの方を読み込むようにする。軽量化のため -->
  <?= $this->Html->script('fullcalendar_locale/ja.js') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->script(API['GOOGLE_MAP_API_KEY']) ?>
  <?= $this->Html->script("load-image.all.min.js") ?><!-- 画像の縦横を自動調整してくれるプラグインExif情報関連 -->
  <?= $this->Html->script("jquery.marquee.min.js") ?><!-- 縦方向スクロールしてくれるプラグイン -->
  <script src='/PhotoSwipe-master/dist/photoswipe.min.js'></script> <!-- PhotoSwipe 4.1.3 -->
  <script src='/PhotoSwipe-master/dist/photoswipe-ui-default.min.js'></script> <!-- chart.js@2.8.0 -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script><!-- fullcalendar-3.9.0 -->
  <link href='/PhotoSwipe-master/dist/default-skin/default-skin.css' rel='stylesheet' /> <!-- PhotoSwipe 4.1.3 -->
  <link href='/PhotoSwipe-master/dist/photoswipe.css' rel='stylesheet' /> <!-- PhotoSwipe 4.1.3 -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">

  <?= $this->Html->css('fontello-3eba660b/css/fontello.css') ?>
  <?= $this->Html->css('materialize.min.css') ?>
  <?= $this->Html->css('night-planet.css') ?>
  <?= $this->Html->css('jquery.notifyBar.css') ?>
  <?= $this->Html->css('fullcalendar.min.css') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->css('jquery.marquee.min.css') ?><!-- marquee -->
  <?= $this->Html->css('swiper.min.css') ?><!-- swiper-master スライダープラグイン -->

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>
  <?php $id = $this->request->getSession()->read('Auth.Owner.id') ?>
  <?php $role = $this->request->getSession()->read('Auth.Owner.role') ?>
<body id="shop-default">
  <ul id="slide-out" class="side-nav fixed">
    <li>
      <div class="user-view">
      <div class="background" style="background-color: orange;">
        </div>
        <a href="#!user"><img class="circle" src="<?= $owner->icon ?>"></a>
        <a href="#!name"><span class="white-text name"><?=$this->request->getSession()->read('Auth.Owner.name')?></span></a>
        <a href="#!email"><span class="white-text email"><?=$this->request->getSession()->read('Auth.Owner.email')?></span></a>
      </div>
    </li>
    <li><a class="waves-effect hoverable" href="/owner/shops/index"><i class="material-icons">dashboard</i><?= SHOP_LM['012'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=top-image":"#";?>" data-tab="top-image" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">image</i><?= SHOP_LM['001'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=catch":"#";?>" data-tab="catch" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">mode_edit</i><?= SHOP_LM['002'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=coupon":"#";?>" data-tab="coupon" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">stars</i><?= SHOP_LM['003'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=cast":"#";?>" data-tab="cast" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">group_add</i><?= SHOP_LM['004'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=tenpo":"#";?>" data-tab="tenpo" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">info_outline</i><?= SHOP_LM['005'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=gallery":"#";?>" data-tab="gallery" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">photo_library</i><?= SHOP_LM['006'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=job":"#";?>" data-tab="job" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">business_center</i><?= SHOP_LM['008'] ?></a></li>
    <li><a href="<?= in_array($this->request->getParam('action'), TAB_CONTROLE)?"/owner/shops/shopEdit?select_tab=sns":"#";?>" data-tab="sns" class="waves-effect hoverable tab-click <?php if($role != 'owner'){echo "btn-disabled";}?>"><i class="material-icons">chat_bubble_outline</i><?= SHOP_LM['010'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/owner/shops/notice"><i class="material-icons">notifications_active</i><?= SHOP_LM['009'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/owner/shops/work_schedule"><i class="material-icons">event_note</i><?= SHOP_LM['011'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/owner/shops/option"><i class="material-icons">settings</i><?= SHOP_LM['013'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/owner/owners"><i class="material-icons">home</i><?= COMMON_LM['004'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/other/faq"><i class="material-icons">help_outline</i><?= COMMON_LM['001'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/other/contract"><i class="material-icons">contact_mail</i><?= COMMON_LM['002'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/other/privacy_policy"><i class="material-icons">priority_high</i><?= COMMON_LM['003'] ?></a></li>
    <li><a class="waves-effect hoverable" href="/other/terms"><i class="material-icons">description</i><?= COMMON_LM['005'] ?></a></li>
    <li><div class="divider"></div></li>
    <li><a href="/owner/owners/logout" class="waves-effect"><i class="material-icons" href="">keyboard_backspace</i><?= COMMON_LM['007'] ?></a></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  </ul>
  <div class="nav-header-cron-dummy"></div>
  <nav id="nav-header-menu" class="nav-header-menu nav-opacity">
    <div class="nav-wrapper">
      <a href="#!" data-activates="slide-out" class="button-collapse oki-button-collapse"><i class="material-icons">menu</i></a>
      <a href="#!" class="brand-logo oki-brand-logo"><?= LT['001'].' '.LT['004'] ?></a>
      <ul class="right">
        <li><a data-target="modal-help" class="modal-trigger"><i class="material-icons">help</i></a></li>
      </ul>
    </div>
  </nav>
  <!-- ヘルプモーダル -->
  <?= $this->element('modal/helpShopModal'); ?>
  <?= $this->element('modal/jobModal'); ?>
  <?= $this->fetch('content') ?>
  <footer class="page-footer">
    <div class="footer-copyright oki-footer-copyright">
      <?= LT['002']; ?>
      <?=(2018-date('Y'))?' - '.date('Y'):'';?> <?= LT['003'] ?>
    </div>
    <!-- START #return_top -->
    <div id="return_top">
      <div class="fixed-action-btn">
        <a class="btn-floating btn-large black">
          <i class="large material-icons">keyboard_arrow_up</i>
        </a>
      </div>
    </div>
    <!-- END #return_top -->
  </footer>
</body>
</html>
