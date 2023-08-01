<!DOCTYPE html>
<html id="html-header" class="scrollspy">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
  <?= $this->element('analytics_key'); ?>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
    if(isset($shop) || isset($cast)):
  ?>
    <meta property="og:site_name" content="<?=LT['000']?>" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?=$shopInfo['shop_url']?>" />
    <meta property="og:title" content="<?=isset($shop)?$shop->name:$cast->shop->name?>" />
    <meta property="og:description" content="<?=isset($shop)?h($shop->catch):h($cast->shop->catch)?>" />
    <meta property="og:image" content="<?=isset($shop)?PUBLIC_DOMAIN.$shop->top_image:PUBLIC_DOMAIN.$cast->shop->top_image?>" />
  <?php 
    else:
  ?>
    <meta property="og:site_name" content="<?=LT['000']?>" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?=PUBLIC_DOMAIN.DS?>" />
    <meta property="og:title" content="<?=$title?>" />
    <meta property="og:description" content="<?=$description?>" />
    <meta property="og:image" content="<?=PATH_ROOT['NIGHT_PLANET_IMAGE']?>" />
  <?php
    endif;
  ?>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"> -->
  <title>
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('apple-touch-icon-precomposed', '/night_planet_top_favicon.png', [
      'type'=>'icon',
      'size' => '144x144',
      'rel'=>'apple-touch-icon-precomposed'
  ])."\n";?>
  <?= SIMPLE_NO_INDEX ? $this->Html->meta('robots',['content'=> 'noindex']): "";?>
  <?= NO_FOLLOW ? $this->Html->meta('robots',['content'=> 'nofollow']): "";?>
  <?= $this->Html->meta('description',['content'=> $description]) ?>
  <?= $this->Html->meta('icon') ?>
  <?= $this->Html->script('jquery-3.1.0.min.js') ?>
  <!-- <?= $this->Html->script('materialize.js') ?> --><!-- 検証用 -->
  <?= $this->Html->script('materialize.min.js') ?>
  <?= $this->Html->script('map.js') ?>
  <?= $this->Html->script('night-planet.js') ?>
  <?= $this->Html->script('ja_JP.js') ?>
  <?= $this->Html->script('jquery.notifyBar.js') ?>
  <?= $this->Html->script('ajaxzip3.js') ?>
  <?= $this->Html->script('masonry.pkgd.min.js') ?><!-- タイル表示プラグイン TODO: 未使用状態 -->
  <?= $this->Html->script('moment.min.js') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->script('fullcalendar.min.js') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->script('fullcalendar_locale/ja.js') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->script(API['GOOGLE_MAP_API_KEY']) ?>
  <?= $this->Html->script("load-image.all.min.js") ?><!-- 画像の縦横を自動調整してくれるプラグインExif情報関連 -->
  <?= $this->Html->script("jquery.marquee.min.js") ?><!-- 縦方向スクロールしてくれるプラグイン -->
  <?= $this->Html->script("swiper.min.js") ?><!-- swiper-master スライダープラグイン -->
  <?= $this->Html->script("infinite-scroll.pkgd.min.js") ?><!-- 無限スクロール プラグイン -->
  <script src='/PhotoSwipe-master/dist/photoswipe.min.js'></script> <!-- PhotoSwipe 4.1.3 -->
  <script src='/PhotoSwipe-master/dist/photoswipe-ui-default.min.js'></script> <!-- PhotoSwipe 4.1.3 -->
  <link href='/PhotoSwipe-master/dist/default-skin/default-skin.css' rel='stylesheet' /> <!-- PhotoSwipe 4.1.3 -->
  <link href='/PhotoSwipe-master/dist/photoswipe.css' rel='stylesheet' /> <!-- PhotoSwipe 4.1.3 -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">

  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>--><!-- 画面ローディング -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-center-circle.min.css" />--><!-- 画面ローディング -->

  <?= $this->Html->css('fontello-3eba660b/css/fontello.css') ?>
  <?= $this->Html->css('materialize.min.css') ?>
  <?= $this->Html->css('night-planet.css') ?>
  <?= $this->Html->css('options.css') ?>
  <?= $this->Html->css('instagram.css') ?>
  <?= $this->Html->css('jquery.notifyBar.css') ?>
  <?= $this->Html->css('fullcalendar.min.css') ?><!-- fullcalendar-3.9.0 -->
  <?= $this->Html->css('jquery.marquee.min.css') ?><!-- marquee -->
  <?= $this->Html->css('swiper.min.css') ?><!-- swiper-master スライダープラグイン -->

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>
  <style>
    .swiper-container .swiper-slide img {
        max-width: 100%;
        height: auto;
    }
  </style>
  <?php !empty($userInfo['main_image'])? $mainImage = $userInfo['image_path'].DS.$userInfo['main_image'] : $mainImage = PATH_ROOT['NO_IMAGE02']; ?>
  <?php $id = $this->request->getSession()->read('Auth.User.id') ?>
  <?php $role = $this->request->getSession()->read('Auth.User.role') ?>
<body id="user-default">
  <ul id="slide-out" class="side-nav fixed">
    <li>
      <div class="user-view">
        <div class="background" style="background-color: orange;">
          <!-- <img src="/img/common/area/top1.jpg"> -->
        </div>
        <a href="#!user"><img class="circle" src="<?=$mainImage?>"></a>
        <a href="#!name"><span class="white-text name"><?=!empty($this->request->getSession()->read('Auth.User.name'))?$this->request->getSession()->read('Auth.User.name'):"ゲストさん"?></span></a>
        <a href="#!email"><span class="white-text email"><?=$this->request->getSession()->read('Auth.User.email')?></span></a>
      </div>
    </li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">info_outline</i><?= USER_LM['001'] ?></a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">event_available</i><?= USER_LM['002'] ?></a></li>
    <li><a class="waves-effect" href="#!"><i class="material-icons">trending_up</i><?= USER_LM['003'] ?></a></li>
    <li><a class="waves-effect" href="/"><i class="material-icons">home</i><?= USER_LM['004'] ?></a></li>
    <li><a class="waves-effect" href="<?=SNS['INSTAGRAM']?>" target="_blank"><i class="material-icons">cloud</i><?= USER_LM['005'] ?></a></li>
    <li><a class="waves-effect" href="<?=SNS['FACEBOOK']?>" target="_blank"><i class="material-icons">cloud</i><?= USER_LM['006'] ?></a></li>
    <li><a class="waves-effect" href="<?=SNS['TWITTER']?>" target="_blank"><i class="material-icons">cloud</i><?= USER_LM['007'] ?></a></li>
    <li><a class="waves-effect" href="/other/faq"><i class="material-icons">help_outline</i><?= COMMON_LM['001'] ?></a></li>
    <li><a class="waves-effect" href="<?=API['GOOGLE_FORM_CONTACT']?>" target="_blank"><i class="material-icons">contact_mail</i><?= COMMON_LM['002'] ?></a></li>
    <li><a class="waves-effect" href="/other/privacy_policy"><i class="material-icons">priority_high</i><?= COMMON_LM['003'] ?></a></li>
    <li><a class="waves-effect" href="/other/terms"><i class="material-icons">description</i><?= COMMON_LM['005'] ?></a></li>
    <li><a class="waves-effect" href="/entry/" target="_blank"><i class="material-icons">star_half</i><?= USER_LM['008'] ?></a></li>
    <li><a class="waves-effect" href="<?=ADMIN_DOMAIN?>"><i class="material-icons">vpn_key</i><?= USER_LM['009'] ?></a></li>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  </ul>
  <div class="nav-header-cron-dummy"></div>
  <nav id="nav-header-menu" class="nav-header-menu nav-opacity">
    <div class="nav-wrapper">
      <a href="#!" data-activates="slide-out" class="button-collapse oki-button-collapse"><i class="material-icons">menu</i></a>
      <a href="<?= $is_area != AREA['okinawa']['path'] ? DS.$is_area : DS?>" class="brand-logo oki-brand-logo"><?= LT['001'] ?><?=!empty($is_area)?'<span class="area-logo"> '.AREA[$is_area]['label'].'</span>':"" ?></a>
      <ul class="right nav-right">
        <li class="nav-search"><a data-target="modal-search" class="modal-trigger"><i id="search-puyon" class="puyon material-icons">search</i><span>検索する</span></a></li>
        <li class="nav-account-login <?=true?' lock':' unlock'?>"><a data-target="modal-login" class="modal-trigger"><i class="material-icons"><?=true?'lock':'lock_open'?></i><span><?=true?' ログイン':' マイページ'?></span></a></li>
      </ul>
    </div>
  </nav>
  <!-- 検索モーダル START -->
  <?= $this->element('modal/searchModal'); ?>
  <!-- 検索モーダル END -->
  <!-- ログインモーダル START -->
  <?= $this->element('modal/loginModal'); ?>
  <!-- ログインモーダル END -->
  <!-- クーポンモーダル START -->
  <?= $this->element('modal/couponModal'); ?>
  <!-- クーポンモーダル END -->
  <!-- 今日のメンバーモーダル START -->
  <?= $this->element('modal/todayMemberModal'); ?>
  <!-- 今日のメンバーモーダル END -->
  <!-- シェアモーダル START -->
  <?= $this->element('modal/sharerModal'); ?>
  <!-- シェアモーダル END -->
  <!-- シェアモーダル START -->
  <?= $this->element('modal/shopSharerModal'); ?>
  <!-- シェアモーダル END -->
  <!-- photoSwipe START -->
  <?= $this->element('photoSwipe'); ?>
  <!-- photoSwipe END -->
  <div class="wrap">
    <?= $this->fetch('content') ?>
    <footer class="page-footer">
      <div class="row">
        <div class="col s12 m6 l3"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">info_outline</i><?= USER_LM['001'] ?></span><a class="" href="#!"></a></div></div>
        <div class="col s12 m6 l3"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">event_available</i><?= USER_LM['002'] ?></span><a class="" href="#!"></a></div></div>
        <div class="col s12 m6 l3"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">trending_up</i><?= USER_LM['003'] ?></span><a class="" href="#!"></a></div></div>
        <div class="col s12 m6 l3"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">home</i><?= USER_LM['004'] ?></span><a class="" href="/"></a></div></div>
      </div>
      <div class="row">
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">cloud</i><?= USER_LM['005'] ?></span><a class="" href="<?=SNS['INSTAGRAM']?>" target="_blank"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">cloud</i><?= USER_LM['006'] ?></span><a class="" href="<?=SNS['FACEBOOK']?>" target="_blank"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">cloud</i><?= USER_LM['007'] ?></span><a class="" href="<?=SNS['TWITTER']?>" target="_blank"></a></div></div>
      </div>
      <div class="row">
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">help_outline</i><?= COMMON_LM['001'] ?></span><a class="" href="/other/faq"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">contact_mail</i><?= COMMON_LM['002'] ?></span><a class="" href="<?=API['GOOGLE_FORM_CONTACT']?>" target="_blank"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">priority_high</i><?= COMMON_LM['003'] ?></span><a class="" href="/other/privacy_policy"></a></div></div>
      </div>
      <div class="row">
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">description</i><?= COMMON_LM['005'] ?></span><a class="" href="/other/terms"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">star_half</i><?= USER_LM['008'] ?></span><a class="" href="/entry/" target="_blank"></a></div></div>
        <div class="col s12 m6 l4"><div class="linkbox card-panel hoverable footer-item"><span><i class="material-icons">vpn_key</i><?= USER_LM['009'] ?></span><a class="" href="<?=ADMIN_DOMAIN?>"></a></div></div>
      </div>
      <div class="row">
        <div class="col s12">
          <div class="card-panel footer-description">
            <span><?= CATCHCOPY ?></span>
          </div>
        </div>
      </div>
      <div class="footer-copyright oki-footer-copyright">
        <?= LT['002']; ?>
        <?=(2018-date('Y'))?' - '.date('Y'):'';?> <?= LT['003'] ?>
      </div>
      <!-- START #return_top -->
      <div id="return_top" class="hide-on-med-and-down">
        <div class="fixed-action-btn">
          <a class="btn-floating btn-large black">
            <i class="large material-icons">keyboard_arrow_up</i>
          </a>
        </div>
      </div>
      <!-- END #return_top -->
    </footer>
  </div>
  <script>

    // プヨンアニメーション
    looopAnimation("search-puyon", "puyon", 900);
    // Params
    var sliderSelector = '.main-swiper',
        options = {
          init: false,
          loop: true,
          speed:800,
          slidesPerView: 2, // or 'auto'
          // spaceBetween: 10,
          centeredSlides : true,
          effect: 'coverflow', // 'cube', 'fade', 'coverflow',
          autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },
          coverflowEffect: {
            rotate: 50, // Slide rotate in degrees
            stretch: 0, // Stretch space between slides (in px)
            depth: 100, // Depth offset in px (slides translate in Z axis)
            modifier: 1, // Effect multipler
            slideShadows : true, // Enables slides shadows
          },
          grabCursor: true,
          parallax: true,
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          breakpoints: {
            0: {
              slidesPerView: 1,
              spaceBetween: 10
            },
            // when window width is <= 480px
            991: {
              slidesPerView: 2,
              spaceBetween: 20
            },
            // when window width is <= 640px
 
          },
          // Events
          on: {
            imagesReady: function(){
              this.el.classList.remove('loading');
            }
          }
        };

    var mainSwiper = new Swiper(sliderSelector, options);

    // Initialize slider
    mainSwiper.init();

    var subSwiper = new Swiper('.sub-swiper', {
      pagination: '.swiper-pagination',
      paginationClickable: true,
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
      loop: true,
      speed: 200,
      autoplay: {
        delay: 1500,
        disableOnInteraction: false,
      },
      slidesPerView: 2,
      centeredSlides : true,
      slideToClickedSlide: true,
      visibilityFullFit: true,
      spaceBetween: 1,
      breakpoints: {
        543: {
          slidesPerView: 2
        }
      },
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true
      }
    });
    // Initialize slider
    subSwiper.init();
  </script>
</body>
</html>
