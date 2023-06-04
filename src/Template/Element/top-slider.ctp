<section id="top-slider" class="swiper-container main-swiper loading">
    <div class="swiper-wrapper">
		<?php
			foreach ($adsenses['main_adsenses'] as $key => $value) :
		?>
        <div class="swiper-slide linkbox"
            style="background-image:url(<?= $value->img_path ?>)">
            <img src="<?= $value->img_path ?>" class="entity-img" />
            <div class="content">
                <span class="caption" data-swiper-parallax="-20%" data-swiper-parallax-scale=".7"><?=$value->Shops['catch']?></span>
			</div>
			<a href="<?=$value->shop_url?>"></a>
		</div>
		<?php
			endforeach;
		?>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-button-next swiper-button-white"></div>
</section>
