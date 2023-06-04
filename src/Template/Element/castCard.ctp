<div id="search-result">
	<div class="col s12">
		<?php $key_word = empty($this->request->query('key_word'))? "指定なし": $this->request->query('key_word'); ?>
		<?php $area = empty($this->request->query('area'))? "指定なし": AREA[$this->request->query('area')]['label']; ?>
		<?php $genre = empty($this->request->query('genre'))? "指定なし": GENRE[$this->request->query('genre')]['label']; ?>
		<?php if(isset($unknow)): ?>
			<span class="header"><?=h($area.'の'.$genre.'　'.count($search).'人')?></span>
		<?php else: ?>
			<div class="search-word white-text left header brown darken-1"><?=h("スタッフの検索結果 ".count($search)." 人")?></div>
			<div class="search-word white-text left header red darken-1"><?=h("キーワード「".$key_word."」")?></div>
			<div class="search-word white-text left header blue darken-1"><?=h("エリア「".$area."」")?></div>
			<div class="search-word white-text left header orange darken-1"><?=h("ジャンル「".$genre."」")?></div>
			<?php if (count($search) == 0) { ?>
				<p class="right message">検索結果が０人でした。条件を変更し、もう一度検索してみてください。</p>
			<?php } ?>
		<?php endif; ?>
	</div>
	<?php if(count($search) > 0) { ?>
		<ul>
			<?php foreach ($search as $key => $rows): ?>
				<li class="linkbox col card horizontal waves-effect hoverable search-result-card">
					<div class="card-image">
						<img src="<?= $rows->icon ?>" class="card-image-img" height="300">
					</div>
					<div class="card-stacked">
						<h1>
							<?php if (!empty($rows->snss[0]->instagram)): ?>
								<a style="margin-left: 80%;">
									<span class="Instagram_logo1"></span>
								</a>
							<?php endif; ?>
							<?php if (!empty($rows->snss[0]->facebook)): ?>
								<a style="margin-left: 90%;">
									<span class="facebook_logo1"></span>
								</a>
							<?php endif; ?>
							<?php if (!empty($rows->snss[0]->twitter)): ?>
								<a style="margin-left: 100%;">
									<span class="twitter_logo1"></span>
								</a>
							<?php endif; ?>
						</h1>
						<div class="card-content linkbox__card-content favorite">
							<?=$this->User->get_favo_html('search', $rows)?>
							<span class="card-tag white-text red"><?= $rows['name']?></span><span class="card-tag white-text red"><?= $rows->shop['name']?></span>
							<p class="gray-text text-darken-2"><?= $rows['message']
							. '<br><span class="card-tag white-text orange darken-1">'
							 . GENRE[$rows->shop['genre']]['label'] . '</span><span class="card-tag white-text blue darken-1">'
							  . $rows->shop['addr21'] . '</span>' . $rows->shop['strt21']?></p>
						</div>
					</div>
					<a href="<?=DS.$rows->shop['area'].DS.'cast'.DS.$rows['id']
						.'?genre='.$rows->shop['genre'].'&name='.$rows->shop['name']
						.'&shop='.$rows->shop['id'].'&nickname='.$rows['nickname']?>"></a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php }  ?>
</div>