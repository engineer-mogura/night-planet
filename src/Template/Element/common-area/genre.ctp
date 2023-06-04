
<div id="genre" class="container">
	<div class="row">
		<div class="col s12 m12 l8">
			<div class="row">
				<div id="wrapper">
					<span id="dummy" style="display: hidden;"></span>
					<?= $this->Flash->render() ?>
					<?= $this->element('nav-breadcrumb'); ?>
					<?= $this->element('shopCard'); ?>
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
