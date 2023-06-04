<?php foreach ($shop->reviews as $key => $value) : ?>
	<li class="collection-item other-review-section__ul__li avatar">
		<img src="<?=$value->user->icon?>" alt="" class="circle">
		<span class="title"><?=$value->user->name?></span>
		<h6><?=$value->user->created?> に参加</h6>
		<span class="truncate truncate__show__review"><?=$value->comment?></span>
		<a href="#!" class="secondary-content">
			<div class="rateit"
					data-rateit-readonly=true
					data-rateit-value=<?=$value->review_average?>
					data-rateit-max="5">
			</div>
		</a>
	</li>
<?php endforeach ; ?>