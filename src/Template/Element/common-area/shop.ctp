<div id="shop" class="container">
	<?= $this->Flash->render() ?>
	<?= $this->element('nav-breadcrumb'); ?>
	<div class="row">
		<div id="shop-main" class="col s12 m12 l8">
			<!-- 店舗ヘッダ START -->
			<div class="row shop-head-section">
				<img class="responsive-img" width="100%" src=<?= $shop->top_image ?> />
				<div class="shop-head">
					<div class="shop-head-line1 col s12">
						<ul class="shop-head-line1__ul">
							<li class="shop-head-line1__ul_li favorite">
									<?= $this->User->get_favo_html('header', $shop) ?>
							</li>
							<li class="shop-head-line1__ul_li voice">
								<div class="shop-head-line1__ul_li__voice">
									<?= $this->User->get_comment_html('header',  $shop) ?>
								</div>
							</li>
							<li class="shop-head-line1__ul_li">
								<div class="shop-head-line1__ul_li__voice">
									<a class="btn-floating btn orange darken-4">
										<i class="material-icons">camera_alt</i>
									</a>
									<span class="shop-head-line1__ul_li__image__count">0</span>
								</div>
							</li>
						</ul>
					</div>
					<div class="shop-head-line2 col s12">
						<ul class="shop-head-line1__ul">
							<li class="shop-head-line1__ul_li">
								<?= !empty($shop->name) ? h($shop->name) : h('-') ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- 店舗ヘッダ END -->
			<!-- キャッチコピー START -->
			<div class="row section header-discription-message">
				<div class="card-panel light-blue">
					<?php if ($shop->catch != '') :
						echo ($this->Text->autoParagraph($shop->catch));
					else :
						echo ('キャッチコピーがありません。');
					endif;
					?>
				</div>
			</div>
			<!-- キャッチコピー END -->
			<!-- 更新情報 START -->
			<?= $this->element('info-marquee'); ?>
			<!-- 更新情報 END -->
			<!-- 店舗メニュー START -->
			<div id="menu-section" class="option-menu-color-<?= $shop->shop_options[0]['menu_color'] ?> row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="shop-menu-section section-label"><span> SHOP MENU </span></p>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['COUPON'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section coupon"></br>COUPON</span>
						<a class="waves-effect waves-light modal-trigger" href="#coupons-modal"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['WORK_SCHEDULE'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section work-schedule"></br>MEMBER</span>
						<a class="waves-effect waves-light modal-trigger" href="#today-member-modal"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['EVENT'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section event"></br>NEWS</span>
						<a class="waves-effect waves-light" href="#event-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= preg_grep("/^" . SHOP_MENU_NAME['STAFF'] . "/", $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section casts"></br>STAFF</span>
						<a class="waves-effect waves-light" href="#p-casts-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['DIARY'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section diary"></br>DIARY</span>
						<a class="waves-effect waves-light" href="#diary-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['SHOP_GALLERY'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section shop-gallery"></br>GALLERY</span>
						<a class="waves-effect waves-light" href="#shop-gallery-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="<?= empty($shop->snss[0]['instagram']) ? 'grey ' : 'lighten-4 ' ?>linkbox card-panel hoverable center-align">
						<span class="menu-section instagram"></br>INSTAGRAM</span>
						<a class="waves-effect waves-light" href="#instagram-section"></a>
					</div>
				</div>
				<!-- line facebook廃止 -->
				<!-- <div class="col s4 m4 l4">
					<div
						class="<?=/*empty($shop->snss[0]['facebook'])*/ !$isShow_fb ? 'grey ' : 'lighten-4 ' ?>linkbox card-panel hoverable center-align">
						<span class="menu-section facebook"></br>Facebook</span>
						<a class="waves-effect waves-light" href="#facebook-section"></a>
					</div>
				</div> -->
				<!-- <div class="col s4 m4 l4">
					<div
						class="<?= empty($shop->snss[0]['line']) ? 'grey ' : 'lighten-4 ' ?>linkbox card-panel hoverable center-align">
						<span class="menu-section line"></br>LINE</span>
						<a class="waves-effect waves-light" href="#line-section"></a>
					</div>
				</div> -->
				<!-- line facebook廃止 -->
				<div class="col s4 m4 l4">
					<div class="<?= empty($shop->snss[0]['twitter']) ? 'grey ' : 'lighten-4 ' ?>linkbox card-panel hoverable center-align">
						<span class="menu-section twitter"></br>TWITTER</span>
						<a class="waves-effect waves-light" href="#twitter-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section comment"></br>VOICE</span>
						<a class="waves-effect waves-light" href="#comment-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<span class="menu-section map"></br>MAP</span>
						<a class="waves-effect waves-light" href="#map-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['SYSTEM'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section system"></br>SYSTEM</span>
						<a class="waves-effect waves-light" href="#shop-info-section"></a>
					</div>
				</div>
				<div class="col s4 m4 l4">
					<div class="lighten-4 linkbox card-panel hoverable center-align">
						<?= in_array(SHOP_MENU_NAME['RECRUIT'], $update_icon) ? '<div class="new-info"></div>' : '' ?>
						<span class="menu-section recruit"></br>RECRUIT</span>
						<a class="waves-effect waves-light" href="#recruit-section"></a>
					</div>
				</div>
			</div>
			<!-- 店舗メニュー END -->
			<!-- スタッフリスト START -->
			<div id="p-casts-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="casts-label section-label"><span> STAFF </span></p>
				</div>
				<?php if (count($shop->casts) > 0) : ?>
					<?php foreach ($shop->casts as $cast) : ?>
						<div class="p-casts-section__list center-align col s3 m3 l3 favorite">
							<?= $this->User->get_favo_html('staff_list', $cast) ?>
							<a href="<?= DS . $shop['area'] . DS . PATH_ROOT['CAST'] . DS . $cast['id'] ?>">
								<img src="<?= $cast->icon ?>" alt="<?= $cast->nickname ?>" class="p-casts-section__list_img_circle circle">
							</a>
							<div class="p-casts-section__p-casts-section__list__icons">
								<?= isset($cast->new_cast) ? '<i class="material-icons icons__new-icon puyon">fiber_new</i>' : '' ?>
								<?= isset($cast->update_cast) ? '<i class="material-icons icons__update-icon puyon">update</i>' : '' ?>
							</div>
							<span class="p-casts-section__p-casts-section__list__name truncate"><?= $cast->nickname ?></span>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<p class="col">スタッフの登録はありません。</p>
				<?php endif; ?>
			</div>
			<!-- スタッフリスト END -->
			<!-- 日記 START -->
			<div id="diary-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="diary-label section-label"><span> DIARY </span></p>
				</div>
				<?php if (count($diarys) > 0) : ?>
					<ul class="collection z-depth-3">
						<?php foreach ($diarys as $key => $value) : ?>
							<li class="linkbox collection-item avatar">
								<div class="archiveLink">
									<input type="hidden" name="diary_id" value=<?= $value->id ?>>
									<?php !empty($value['gallery'][0]['file_path']) ? $imgPath = $value['gallery'][0]['file_path'] : $imgPath = PATH_ROOT['NO_IMAGE01']; ?>
									<img src="<?= $value->icon ?>" alt="" class="circle">
									<h6 class="li-linkbox__a__h6"><?= $value->created->nice() ?>
										<a class="li-linkbox__a-image btn-floating btn red darken-3 lighten-1"><i class="material-icons">camera_alt</i></a>
										<span class="li-linkbox__a-image__count"><?= $value->gallery_count ?></span>
									</h6>
									<span class="card-tag white-text red"><?= $value->cast->nickname ?></span></br>
									<span class="truncate"><?= $value['title'] ?><br><?= $value['content'] ?></span>
									<?= $this->User->get_favo_html('new_info_favo_disable', $value) ?>
									<a class="waves-effect hoverable" href="<?= DS . $value->cast->shop['area'] . DS . PATH_ROOT['DIARY'] . DS . $value->cast->id ?>"></a>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="col">まだ日記がありません。</p>
				<?php endif ?>
			</div>
			<!-- 日記 END -->
			<!-- 店舗情報 START -->
			<div id="shop-info-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="shop-info-label section-label"><span> SYSTEM </span></p>
				</div>
				<div class="col s12 m12 l12">
					<table id="basic-info" class="bordered common-table z-depth-2" border="1">
						<tbody>
							<tr>
								<th class="table-header" colspan="2" align="center">
									<?= !empty($shop->name) ? h($shop->name) : h('-') ?>
								</th>
							</tr>
							<tr>
								<th align="center">所在地</th>
								<td name="address"><?= !empty($shop->full_address) ? h($shop->full_address) : h('-') ?>
								</td>
							</tr>
							<tr>
								<th align="center">連絡先</th>
								<td><?php if (!empty($shop->tel)) : ?>
										<a href="tel:<?= $shop->tel ?>"><?= $shop->tel ?></a>
									<?php else : {
												h('-');
											}
										endif; ?>
								</td>
							</tr>
							<tr>
								<th align="center">営業時間</th>
								<td><?php if ((!empty($shop->bus_from_time))) {
											$busTime = $this->Time->format($shop->bus_from_time, 'HH:mm')
												. " ～ " . (empty($shop->bus_to_time) ? 'ラスト' : $this->Time->format($shop->bus_to_time, 'HH:mm'));
											if (!empty($shop->bus_hosoku)) {
												$busTime = $busTime .= "</br>" . $shop->bus_hosoku;
											}
											echo (mb_convert_kana($busTime, 'N'));
										} else {
											echo ('-');
										} ?>
								</td>
							</tr>
							<?php if (!empty($shop->owner->shops)) : ?>
								<tr>
									<th align="center">姉妹店</th>
									<td>
										<?php foreach ($shop->owner->shops as $key => $value) : ?>
											<?= $key > 0 ? "</br>" : null ?>
											<a href="<?= $value->shopInfo['shop_url'] ?>" target="_self"><?= $value->name ?></a>
										<?php endforeach; ?>
									</td>
								</tr>
							<?php endif; ?>

							<tr>
								<th align="center">WEBサイト</th>
								<?php if (!empty($shop->web_site)) : ?>
									<td><a href="<?= $shop->web_site ?>" target="_brank"><?= $shop->web_site ?></a></td>
								<?php else : ?>
									<td><?= h('-') ?></td>
								<?php endif; ?>
							</tr>
							<tr>
								<th align="center" valign="top">システム</th>
								<td><?= !empty($shop->shop_system) ? $this->Text->autoParagraph($shop->shop_system) : h('-') ?>
								</td>
							</tr>
							<tr>
								<th align="center">ご利用できるクレジットカード</th>
								<td><?php if (!empty($shop->credit)) : ?>
										<?php $array = explode(',', $shop->credit); ?>
										<?php for ($i = 0; $i < count($array); $i++) : ?>
											<div class="chip" name="" value="">
												<img src="<?= PATH_ROOT['CREDIT'] . $array[$i] ?>.png" id="<?= $array[$i] ?>" alt="<?= $array[$i] ?>">
												<?= $array[$i] ?>
											</div>
										<?php endfor; ?>
									<?php else : echo ('-');
										endif; ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- 店舗情報 END -->
			<!-- instagram START -->
			<?php if (!empty($shop->snss[0]['instagram'])) : ?>
				<div id="instagram-section" class="row shop-menu section scrollspy">
					<div class="light-blue accent-2 card-panel col s12 center-align">
						<p class="instagram-label section-label"><span> INSTAGRAM </span></p>
					</div>
					<?php if (!empty($ig_error)) :
						echo ('<p class="col">' . $ig_error . '</p>');
					elseif ($ig_data->media_count == 0) :
						echo ('<p class="col">まだ投稿がありません。</p>');
					else :
					?>
						<!-- photoSwipe START -->
						<?= $this->element('Instagram'); ?>
						<!-- photoSwipe END -->
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<!-- instagram END -->
			<!-- facebook START -->
			<!-- <?php if ($isShow_fb) : ?>
				<?php if (!empty($shop->snss[0]['facebook'])) : ?>
					<div id="facebook-section" class="row shop-menu section scrollspy">
						<div class="light-blue accent-2 card-panel col s12 center-align">
							<p class="facebook-label section-label"><span> facebook </span></p>
						</div>
						<div id="fb-root"></div>
						<script async defer crossorigin="anonymous"
							src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v4.0&appId=2084171171889711&autoLogAppEvents=1"></script>
					</div>
					<div class="fb-container">
						<div class="fb-page" data-href="https://www.facebook.com/<?= $shop->snss[0]['facebook'] ?>"
							data-tabs="timeline,messages" data-width="500" data-height="" data-small-header="false"
							data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
							<blockquote cite="https://www.facebook.com/<?= $shop->snss[0]['facebook'] ?>/"
								class="fb-xfbml-parse-ignore"><a
									href="https://www.facebook.com/<?= $shop->snss[0]['facebook'] ?>/"></a></blockquote>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?> -->
			<!-- facebook END -->
			<!-- twitter START -->
			<?php if (!empty($shop->snss[0]['twitter'])) : ?>
				<div id="twitter-section" class="row shop-menu section scrollspy">
					<div class="light-blue accent-2 card-panel col s12 center-align">
						<p class="twitter-label section-label"><span> TWITTER </span></p>
					</div>
					<div class="twitter-box col">
						<a class="twitter-timeline" href="https://twitter.com/<?= $shop->snss[0]['twitter'] ?>?ref_src=twsrc%5Etfw" data-tweet-limit="3">Tweets by <?= $shop->snss[0]['twitter'] ?></a>
						<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
					</div>
				</div>
			<?php endif; ?>
			<!-- twitter END -->
			<!-- お知らせ START -->
			<div id="event-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="event-label section-label"><span> NEWS </span></p>
				</div>
				<?php if (count($shop->shop_infos) > 0) : ?>
					<div class="my-gallery col s12">
						<?php foreach ($shop->shop_infos[0]->gallery as $key => $value) : ?>
							<figure>
								<a href="<?= $value['file_path'] ?>" data-size="800x1000">
									<img width="100%" src="<?= $value['file_path'] ?>" alt="<?= $value['date'] ?>" />
								</a>
								<figcaption style="display:none;">
									<?= $value['date'] ?>
								</figcaption>
							</figure>
						<?php endforeach; ?>
					</div>
					<div class="col s12 event-section__content">
						<p class="right-align"><?= $shop->shop_infos[0]->created->nice() ?></p>
						<p class="title"><?= $shop->shop_infos[0]->title ?></p>
						<p><?= $this->Text->autoParagraph($shop->shop_infos[0]->content) ?></p>
						<div class="favorite">
							<?= $this->User->get_favo_html('view_info', $shop->shop_infos[0]) ?>
						</div>
						<span style="float:right;">
							<a href="<?= DS . $shopInfo['area']['path'] . DS . PATH_ROOT['NOTICE'] . DS . $shop->id . "?area=" . $shop->area . "&genre=" . $shop->genre .
													"&shop=" . $shop->id . "&name=" . $shop->name ?>" class="waves-effect waves-green btn"><?= COMMON_LB['052'] ?>
							</a>
						</span>
					</div>
				<?php else : ?>
					<p class="col">お知らせはありません。</p>
				<?php endif; ?>
			</div>
			<!-- お知らせ END -->
			<!-- 店舗ギャラリー START -->
			<div id="shop-gallery-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="shop-gallery-label section-label"><span> GALLERY </span></p>
				</div>
				<?= count($shop->gallery) == 0 ? '<p class="col">まだ投稿がありません。</p>' : ""; ?>
				<div class="my-gallery">
					<?php foreach ($shop->gallery as $key => $value) : ?>
						<figure>
							<a href="<?= $value['file_path'] ?>" data-size="800x1000">
								<img width="100%" src="<?= $value['file_path'] ?>" alt="<?= $value['date'] ?>" />
							</a>
							<figcaption style="display:none;">
								<?= $value['date'] ?>
							</figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</div>
			<!-- 店舗ギャラリー END -->
			<!-- 口コミ START -->
			<div id="comment-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="comment-label section-label"><span> VOICE </span></p>
				</div>
				<span style="float:right;">
					<a href="<?= DS . $shop['area'] . DS . PATH_ROOT['REVIEW'] . DS . $shop['id'] ?>" class="waves-effect waves-green orange btn">レビュー画面へ行く
					</a>
				</span>
			</div>
			<!-- 口コミ MAP END -->
			<!-- GOOGLE MAP START -->
			<div id="map-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="map-label section-label"><span> MAP </span></p>
				</div>
				<div style="width:100%;height:300px;" id="google_map"></div>
			</div>
			<!-- GOOGLE MAP END -->
			<!-- 求人情報 START -->
			<div id="recruit-section" class="row shop-menu section scrollspy">
				<div class="light-blue accent-2 card-panel col s12 center-align">
					<p class="recruit-label section-label"><span> RECRUIT </span></p>
				</div>
				<div class="col s12 m12 l12">
					<table class="bordered common-table z-depth-2" border="1">
						<tbody>
							<tr>
							<tr>
								<th class="table-header" colspan="2" align="center">
									<?php if (!empty($shop->name)) :
										echo ($shop->name);
									else : echo ('-');
									endif;
									?>
								</th>
							</tr>
							<tr>
								<th align="center">業種</th>
								<td>
									<?= !empty($shop->jobs[0]->industry) ?
										$this->Text->autoParagraph($shop->jobs[0]->industry) : h('-') ?>
								</td>
							</tr>
							<tr>
								<th align="center">職種</th>
								<td>
									<?= !empty($shop->jobs[0]->job_type) ?
										$this->Text->autoParagraph($shop->jobs[0]->job_type) : h('-') ?>
								</td>
							</tr>
							<th align="center">時間</th>
							<td><?php if ((!empty($shop->jobs[0]->work_from_time))) :
										$workTime = $this->Time->format($shop->jobs[0]->work_from_time, 'HH:mm')
											. " ～ " . (empty($shop->jobs[0]->work_to_time) ? 'ラスト' : $this->Time->format($shop->jobs[0]->work_to_time, 'HH:mm'));
										if (!empty($shop->jobs[0]->work_time_hosoku)) :
											$workTime = $workTime .= "</br>" . $shop->jobs[0]->work_time_hosoku;
										endif;
										echo (mb_convert_kana($workTime, 'N'));
									else : echo ('-');
									endif; ?>
							</td>
							</tr>
							<th align="center">資格</th>
							<td><?php if ((!empty($shop->jobs[0]->from_age))
										&& (!empty($shop->jobs[0]->to_age))
									) :
										$qualification = $shop->jobs[0]->from_age . "歳～" . $shop->jobs[0]->to_age . "歳くらいまで";
										if (!empty($shop->jobs[0]->qualification_hosoku)) :
											$qualification = $qualification .= "</br>" . $shop->jobs[0]->qualification_hosoku;
										endif;
										echo (mb_convert_kana($qualification, 'N'));
									else : echo ('-');
									endif; ?>
							</td>
							</tr>
							<th align="center">休日</th>
							<td><?php if (!empty($shop->jobs[0]->holiday)) :
										$holiday = $shop->jobs[0]->holiday;
										if (!empty($shop->jobs[0]->holiday_hosoku)) :
											$holiday = $holiday .= "</br>" . $shop->jobs[0]->holiday_hosoku;
										endif;
										echo ($holiday);
									else : echo ('-');
									endif; ?>
							</td>
							</tr>
							<th align="center">待遇</th>
							<td>
								<?php if (!empty($shop->jobs[0]->treatment)) : ?>
									<?php $array = explode(',', $shop->jobs[0]->treatment); ?>
									<?php for ($i = 0; $i < count($array); $i++) : ?>
										<div class="chip" name="" id="<?= $array[$i] ?>" value="<?= $array[$i] ?>"><?= $array[$i] ?></div>
				</div>
			<?php endfor; ?>
		<?php else : echo ('-');
								endif; ?>
		</td>
		</tr>
		<tr>
			<th align="center">PR</th>
			<td>
				<?= !empty($shop->jobs[0]->pr) ?
					$this->Text->autoParagraph($shop->jobs[0]->pr) : h('-') ?>
			</td>
		</tr>
		</tbody>
		</table>
			</div>
			<div class="col s12 m12 l12">
				<table class="tel-table bordered common-table z-depth-2" border="1">
					<tbody>
						<tr>
							<th class="table-header" colspan="2" align="center">応募連絡先</th>
						</tr>
						<tr>
							<th align="center">連絡先1</th>
							<td><?php if (!empty($shop->jobs[0]->tel1)) : ?>
									<a href="tel:<?= $shop->jobs[0]->tel1 ?>"><?= $shop->jobs[0]->tel1 ?></a>
								<?php else : echo ('-');
									endif; ?>
							</td>
						</tr>
						<tr>
							<th align="center">連絡先2</th>
							<td><?php if (!empty($shop->jobs[0]->tel2)) : ?>
									<a href="tel:<?= $shop->jobs[0]->tel2 ?>"><?= $shop->jobs[0]->tel2 ?></a>
								<?php else : echo ('-');
									endif; ?>
							</td>
						</tr>
						<tr>
							<th align="center">メール</th>
							<td><?php if (!empty($shop->jobs[0]->email)) :
										echo ($shop->jobs[0]->email);
									else : echo ('-');
									endif; ?>
							</td>
						</tr>
						<tr>
							<th align="center">LINE ID</th>
							<td><?php if (!empty($shop->jobs[0]->lineid)) :
										echo ($shop->jobs[0]->lineid);
									else : echo ('-');
									endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- 求人情報 END -->
		</div>
	</div>
	<!--デスクトップ用 サイドバー START -->
	<?= $this->element('sidebar'); ?>
	<!--デスクトップ用 サイドバー END -->
</div>
</div>
<!-- ショップ用ボトムナビゲーション START -->
<?= $this->element('shop-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->