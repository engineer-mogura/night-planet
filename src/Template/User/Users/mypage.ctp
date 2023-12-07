<div id="user" class="container">
	<?= $this->Flash->render() ?>
	<?= $this->element('nav-breadcrumb'); ?>
	<div class="row">
		<div id="user-main" class="col s12 m12 l12">
			<!-- ユーザーヘッダ START -->
			<div class="row user-head-section">
				<div class="lighten-4 card-panel user-head-section__content">
					<div class="user-head__line1">
						<ul class="user-head-line1__ul">
							<li class="user-head-line1__ul_li">
								<img src="<?=$this->User->get_u_info('icon')?>" width="75px" height="70px" class="circle">
							</li>
							<li class="user-head-line1__ul_li">
							<h5><?=$this->User->get_u_info('name')?></h5>
							<h6><?=$this->User->get_u_info('created')?> に参加</h6>
							</li>
						</ul>
					</div>
					<div class="user-head__line2">
						<ul class="user-head-line2__ul">
							<li class="user-head-line2__ul_li">
								<div class="user-head-line2__ul_li__favorite">
									<a class="btn-floating btn red lighten-1 modal-trigger" data-target="modal-login">
										<i class="material-icons">favorite</i>
									</a>
									<span class="user-head-line2__ul_li__favorite__count">0</span>
									<spna class="favorite-num">お気に入りの数</span>
								</div>
							</li>
							<li class="user-head-line2__ul_li">
								<div class="user-head-line2__ul_li__voice">
									<a class="btn-floating btn red modal-trigger" data-target="modal-login">
										<i class="material-icons">comment</i>
									</a>
									<span class="user-head-line2__ul_li__voice__count">0</span>
									<span class="voice-num">口コミの数</span>
								</div>
							</li>
							<li class="user-head-line2__ul_li">
								<div class="user-head-line2__ul_li__voice">
									<a class="btn-floating btn orange darken-4">
										<i class="material-icons">camera_alt</i>
									</a>
									<span class="user-head-line2__ul_li__image__count">0</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- ユーザーヘッダ END -->
			<!-- キャッチコピー START -->
			<div class="row section header-discription-message">

			</div>
			<!-- キャッチコピー END -->
			<!-- 更新情報 START -->
			<?= $this->element('info-marquee'); ?>
			<!-- 更新情報 END -->
			<!-- ユーザーメニュー START -->
			<div id="menu-section" class="row shop-menu section scrollspy">
				<div class="accent-2 card-panel col s12 center-align">
					<p class="user-menu-section section-label"><span> MY MENU </span></p>
				</div>
				<div class="col s4 m4 l2">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section profile"></br>PROFILE</span>
						<a class="waves-effect waves-light" href="/user/users/profile"></a>
					</div>
				</div>
				<div class="col s4 m4 l2">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section comment"></br>VOICE</span>
						<a class="waves-effect waves-light" href="#comment-section"></a>
					</div>
				</div>
				<div class="accent-2 card-panel col s12 center-align">
					<p class="favorite-label section-label"><span> MY FAVO </span></p>
				</div>
				<div class="col s4 m4 l2">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section shop"></br>SHOP</span>
						<a class="waves-effect waves-light" href="/user/users/shop_favo"></a>
					</div>
				</div>
				<div class="col s4 m4 l2">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section casts"></br>STAFF</span>
						<a class="waves-effect waves-light" href="/user/users/cast_favo"></a>
					</div>
				</div>
				<div class="col s4 m4 l2">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section shop-gallery"></br>GALLERY</span>
						<a class="waves-effect waves-light" href="#gallery-section"></a>
					</div>
				</div>
			</div>
			<!-- ユーザーメニュー END -->
			<!--フッター START -->
			<p><a href="/user/users/logout">ログアウト</a></p>
			<!--フッター END -->
		</div>
	</div>
</div>
<!-- ショップ用ボトムナビゲーション START -->
<?= $this->element('shop-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->