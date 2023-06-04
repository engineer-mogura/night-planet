<div class="sidebar col s12 m12 l4">
	<div class="section hide-on-med-and-down">
		<!-- シェアボタン START -->
		<?php if(isset($shop) || isset($cast)): ?>
		<P class="center-align"><span class="color-blue"><?=isset($shop) ? $shop->name : $cast->shop->name?></span>をシェアしよう！</p>
		<div class="row sharer-modal">
			<div class="col l6">
				<a class="facebook sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['FACEBOOK'].urlencode($shopInfo['shop_url'])?>">
					<span> Facebook</span>
				</a>
			</div>
			<div class="col l6">
				<a class="twitter sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['TWITTER'].urlencode($shopInfo['shop_url'])?>">
					<span> Twitter</span>
				</a>
			</div>
		</div>
		<div class="row sharer-modal">
			<!-- <div class="col l6">
				<a class="b_hatena sharer-btn waves-effect waves-light btn-large disabled">
					<span> はてブ</span>
				</a>
			</div> -->
			<div class="col l6">
				<a class="line sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['LINE'].urlencode($shopInfo['shop_url'])?>">
					<span> LINE</span>
				</a>
			</div>
		</div>
		<?php else: ?>
		<h5><span class="color-blue"><?=LT['001']?></span>をシェアしよう</h5>
		<div class="row sharer-modal">
			<div class="col l6">
				<a class="facebook sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['FACEBOOK'].urlencode($shopInfo['shop_url'])?>">
					<span> Facebook</span>
				</a>
			</div>
			<div class="col l6">
				<a class="twitter sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['TWITTER'].urlencode($shopInfo['shop_url'])?>">
					<span> Twitter</span>
				</a>
			</div>
		</div>
		<div class="row sharer-modal">
			<!-- <div class="col l6">
				<a class="b_hatena sharer-btn waves-effect waves-light btn-large disabled">
					<span> はてブ</span>
				</a>
			</div> -->
			<div class="col l6">
				<a class="line sharer-btn waves-effect waves-light btn-large" href="<?=SHARER['LINE'].urlencode($shopInfo['shop_url'])?>">
					<span> LINE</span>
				</a>
			</div>
		</div>
		<?php endif; ?>
		<!-- シェアボタン END -->
	</div>
	<!-- 広告枠 START -->
	<?= $this->element('banner'); ?>
	<!-- 広告枠 END -->
</div>