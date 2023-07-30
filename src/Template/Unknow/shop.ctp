<div id="unknow" class="container">
	<div class="row">
		<div class="col s12 m12 l8">
			<div class="row">
				<div id="wrapper">
					<div class="unknow-contents">
						<div class="col s12 m12 l12">
							<p class="unknow-image">
								<img src="<?= PATH_ROOT['NO_IMAGE06'] ?>" class="responsive-img" width="300" height="150">
							</p>
						</div>
						<div class="col s12 m12 l12 unknow-message">
							<h4>お探しのページは見つかりませんでした。</h4>
							<p>お探しのページは準備中、もしくは削除された可能性があります。</p>
							<p>お探しのエリア、ジャンルだと以下に表示された店舗があります。
								また、右上の虫メガネアイコンからもお探しできます。</p>
						</div>
						<?php
							echo ($this->element('shopCard'));
						?>
					</div>
				</div>
			</div>
		</div>
		<!--デスクトップ用 サイドバー START -->
		<?= $this->element('sidebar'); ?>
		<!--デスクトップ用 サイドバー END -->
	</div>
</div>
<!-- 共通ボトムナビゲーション START -->
<?= $this->element('bottom-navigation'); ?>
<!-- 共通ボトムナビゲーション END -->
