<div id="search" class="container">
	<div class="row">
		<div class="col s12 m12 l8">
			<div class="row">
				<div id="wrapper">
					<div>
						<span id="dummy" style="display: hidden;"></span>
						<?= $this->Flash->render() ?>
						<?= $this->element('nav-breadcrumb'); ?>
						<div class="hide-on-med-and-down">
							<?= $this->element('elmSearch'); ?>
						</div>
						<?php
							if($useTemplate == 'shop'): 
						 		echo ($this->element('shopCard'));
							elseif($useTemplate == 'cast'):
								echo ($this->element('castCard'));
							endif;
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
