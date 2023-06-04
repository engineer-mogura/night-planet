
<article id="SNS_Instagram">
    <header>
        <section id="new-photos">
            <div class="row" style="margin-bottom:0px;">
			<div class="col s3 m3 l3">
				<a href="<?=SNS['INSTAGRAM']?>" class="img night-planet-img circle"></a>
            </div>
			<div class="col s6 m6 l6" style="text-align:center">
				<span style="color:#666;font-size: x-small;">ナイプラの新着フォトです</span>
            </div>
			<div class="col s3 m3 l3">
				<a href="<?=SNS['INSTAGRAM']?>" class="img night-planet-chara"></a>
            </div>
        </section>
    </header>
   <!-- CSS で表示切替用 Radio ボタン (非表示) -->
     <input type="radio" name="show-mode" id="show_grid" value="grid"<?php if(API['INSTAGRAM_SHOW_MODE'] === 'grid'){ echo ' checked'; } ?>>
    <main>
<?php
	$days = array('日', '月', '火', '水', '木', '金', '土');
		foreach($new_photos as $key => $post):
			$content = $post->content;
			$content = mb_convert_encoding($content, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
			$content = preg_replace('/\n/', '<BR>', $content);
			$content = preg_replace('/(http[s]{0,1}:\/\/[a-zA-Z0-9\.\/#\?\&=\-_~]+)/', '<a href="$1" target="new" rel="noopener">$1</a>', $content);
			$content = preg_replace('/#([^<>]+?)(\s|\n|\z|#|@)/', '<a href="https://www.instagram.com/explore/tags/$1/" target="new" rel="noopener">#$1</a>$2', $content);
			$content = preg_replace('/@([^<>]+?)(\s|\n|\z|#|@)/', '<a href="https://www.instagram.com/$1/" target="new" rel="noopener">@$1</a>$2', $content);
			$media = $post->photo_path;
?>
        <div style="display: inline-table;">
		<a onclick="click_figure(this)" id="<?='call-figure'.h($key) ?>" class="instagram" title="likes:<?php echo $post->like_count; ?>">
			<div style="background-image: url('<?php echo $media; ?>');">
				<div class="footer-box">
					<span class="badge area-badge truncate"><span class="footer-message"><?=$post->area ." ". $post->genre;?>
					<br><?=$post->name?></span></span>
				</div>
			</div>
<?php
				// 動画の場合
				if($post->media_type == 'VIDEO'):
?>
				<span class="ig-video"></span><!-- 追加要素 -->
<?php
				endif;
?>
				<span class="ig-comment icon-vertical-align"><i class="material-icons">comment</i><?=$post->comments_count;?></span>
				<span class="ig-like icon-vertical-align"><i class="material-icons">favorite</i><?=$post->like_count;?></span>
				<?= $post->media_type == 'VIDEO' ? '<span class="ig-video icon-vertical-align"><i class="small material-icons">play_arrow</i></span>' : "" ?></br>
			</a>
          <time datetime="<?php echo $post->date; ?>"><?php echo '投稿日時：', date('Y年 n月 j日', strtotime($post->date)), ' (', $days[date('w', strtotime($post->date))], ')'; ?></time>
          <p>
            <?php echo $content; ?>
          </p>
        </div>
<?php
		endforeach;
?>
	</main>
<?php
		foreach ($new_photos as $key => $post) {
?>
			<div class="my-gallery" style="display:none;">
				<figure>
					<a href="<?php echo $post->photo_path; ?>" class="instagram call-figure<?=h($key)?>" data-size="800x1000">
						<img itemprop="thumbnail" alt="<?=$post->content; ?>" />
					</a>
					<figcaption style="display:none;">
						<i class="small material-icons">favorite_border</i><?=$post->like_count?> 
						<i class="small material-icons">comment</i><?=$post->comments_count?>
						<?=$post->media_type == 'VIDEO' ? '<i class="small material-icons">play_arrow</i>': "" ?></br>
						<div class="ig-details icon-vertical-align" title="店舗を見に行く"><a href="<?=$post->details;?>">店舗を見に行く</a></div>
						<?=$post->content?>
					</figcaption>
				</figure>
			</div>
<?php
		}
?>
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