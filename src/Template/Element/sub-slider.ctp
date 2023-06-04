<div class="swiper-container sub-swiper col s12">
  <div class="swiper-wrapper">
  <?php
			foreach ($adsenses['sub_adsenses'] as $key => $value) :
		?>
        <div class="swiper-slide linkbox"
            style="background-image:url(<?= $value->img_path ?>)">
            <img src="<?= $value->img_path ?>" class="entity-img" />
			<a href="<?=$value->shop_url?>"></a>
		</div>
		<?php
			endforeach;
		?>
  </div>
  <div class="swiper-pagination"></div>
</div>