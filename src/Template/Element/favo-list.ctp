<?php if ($favos[0]->registry_alias == 'shops') { ?>
	<?php foreach ($favos as $key => $favo) : ?>
		<?php $shop = $favo; ?>
		<li class="linkbox collection-item favo-list-section__ul__li avatar favorite">
			<img src="<?= $shop->top_image ?>" alt="" class="circle">
			<span class="card-tag white-text red"><?= $shop['name'] ?></span>
			<span class="card-tag white-text orange darken-1">
				<?= GENRE[$shop['genre']]['label'] ?>
			</span><br>
			<span class="card-tag white-text blue darken-1">
				<?= $shop['addr21'] ?></span>
			<span class="favo-list-section__ul__li__address"><?= $shop['strt21'] ?></span>
			<h6><?= $favo->created->format('Y/m/d') ?> にお気に入り</h6>
			<a href="#!" class="secondary-content">
				<?= $this->User->get_favo_html('my_favo', $favo) ?>
			</a>
			<a class="waves-effect hoverable" href="<?= DS . $shop['area'] . DS . $shop['genre'] . DS . $shop['id'] ?>">
			</a>
		</li>
	<?php endforeach; ?>
<?php } ?>
<?php if ($favos[0]->registry_alias == 'casts') { ?>
	<?php foreach ($favos as $key => $favo) : ?>
		<?php $cast = $favo; ?>
		<li class="linkbox collection-item favo-list-section__ul__li avatar favorite">
			<img src="<?= $cast->icon ?>" alt="<?= $cast->nickname ?>" class="circle">
			<span class="card-tag white-text red"><?= $cast['name'] ?></span>
			<span class="card-tag white-text red"><?= $cast->shop['name'] ?></span><br>
			<span class="card-tag white-text orange darken-1">
				<?= GENRE[$cast->shop['genre']]['label'] ?>
			</span><br>
			<span class="card-tag white-text blue darken-1">
				<?= $cast->shop['addr21'] ?></span>
			<span class="favo-list-section__ul__li__address"><?= $cast->shop['strt21'] ?></span>
			<h6><?= $favo->created->format('Y/m/d') ?> にお気に入り</h6>
			<a href="#!" class="secondary-content">
				<?= $this->User->get_favo_html('my_favo', $favo) ?>
			</a>
			<a href="<?= DS . $cast->shop['area'] . DS . PATH_ROOT['CAST'] . DS . $cast['id'] ?>">
			</a>
		</li>
	<?php endforeach; ?>
<?php } ?>