<article id="new__photos">
	<header>
		<section>
			<div class="row" style="margin-bottom:0px;">
				<div class="col s3 m3 l3">
					<a href="<?= SNS['INSTAGRAM'] ?>" class="img night-planet-img circle"></a>
				</div>
				<div class="col s6 m6 l6" style="text-align:center">
					<span style="color:#666;font-size: x-small;">ナイプラの新着フォトです</span>
				</div>
				<div class="col s3 m3 l3">
					<a href="<?= SNS['INSTAGRAM'] ?>" class="img night-planet-img circle"></a>
				</div>
		</section>
	</header>
	<main>
		<div class="my-gallery">
			<?php
			$days = array('日', '月', '火', '水', '木', '金', '土');
			foreach ($new_photos as $key => $post) :
				$content = $post->content;
				$content = mb_convert_encoding($content, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
				$content = preg_replace('/\n/', '<BR>', $content);
				$content = preg_replace('/(http[s]{0,1}:\/\/[a-zA-Z0-9\.\/#\?\&=\-_~]+)/', '<a href="$1" target="new" rel="noopener">$1</a>', $content);
				$content = preg_replace('/#([^<>]+?)(\s|\n|\z|#|@)/', '<a href="https://www.instagram.com/explore/tags/$1/" target="new" rel="noopener">#$1</a>$2', $content);
				$content = preg_replace('/@([^<>]+?)(\s|\n|\z|#|@)/', '<a href="https://www.instagram.com/$1/" target="new" rel="noopener">@$1</a>$2', $content);
				$media = $post->photo_path;
			?>
				<figure>
					<a href="<?= $post->photo_path ?>" data-size="800x1000">
						<?php if ($post->media_type == 'VIDEO') : ?>
							<!-- 動画 -->
							<img style="width: 0px;height: 0px;" loading="lazy" src="<?= $post->photo_path ?>" alt="<?= $post->content; ?>" />
							<video muted loop playsinline autoplay>
								<source src="<?= $media; ?>" type="video/mp4">
							</video>
							<div class="footer-box">
								<span class="badge area-badge truncate"><span class="footer-message"><?= $post->area . " " . $post->genre; ?>
										<br><?= $post->name ?></span></span>
							</div>
						<?php else : ?>
							<img width="100%" loading="lazy" src="<?= $post->photo_path ?>" alt="<?= $post->content; ?>" />
							<div class="footer-box">
								<span class="badge area-badge truncate"><span class="footer-message"><?= $post->area . " " . $post->genre; ?>
										<br><?= $post->name ?></span></span>
							</div>
						<?php endif ?>

					</a>
					<figcaption style="display:none;">
						<span><?= " " . $post->area . " > " . $post->genre . " > " . $post->name ?></span><br>
						<i class="small material-icons">favorite_border</i><?= $post->like_count ?>
						<i class="small material-icons">comment</i><?= $post->comments_count ?>
						<?= $post->media_type == 'VIDEO' ? '<i class="small material-icons">play_arrow</i>' : "" ?></br>
						<div class="ig-details btn-large icon-vertical-align" title="店舗を見に行く"><a href="<?= $post->details; ?>">店舗を見に行く</a></div>
						<?= $post->content ?>
					</figcaption>

				</figure>
			<?php endforeach ?>
		</div>

	</main>
	<?php foreach ($new_photos as $key => $post) : ?>

	<?php endforeach ?>
</article>
<script>
	/**
	 * figureをクリックする
	 */
	function click_figure(obj) {
		var target = $(obj).attr('id');

		$("#SNS_Instagram").find('.' + target).trigger("click");
	}
</script>