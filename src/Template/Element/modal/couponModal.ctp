<div id="coupons-modal" class="modal modal-fixed-footer">
	<div class="modal-content">
		<?php if(is_countable($shop->coupons) > 0): ?>
		<ul class="collection with-header">
			<li class="collection-header"><p>😍使用するクーポンをお店側に見せてね😍</p></li>
			<?php foreach($shop->coupons as  $key => $coupon): ?>
				<li class="collection-item">
				<!-- <i class="material-icons circle">folder</i> -->
				<span><?= "#".($key + 1)."　".$this->Time->format($coupon->from_day, 'Y/M/d') ?> ～ <?= $this->Time->format($coupon->to_day, 'Y/M/d') ?></span><br>
				<span class="title blue-text text-darken-2"><?=$coupon->title ?></span>
				<p><?=$this->Text->autoParagraph($coupon->content) ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<div class="">
			<p>😥クーポンの登録はありません。😥</p>
		</div>
		<?php endif; ?>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">とじる</a>
	</div>
</div>