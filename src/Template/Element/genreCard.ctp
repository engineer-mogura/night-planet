<div class="col s12 m12 l12">
	<ul class="card-panel collection with-header">
		<?php foreach ($genreCounts as $key => $row): ?>
			<li class="collection-item linkbox">
				<div><?=$row['label'].' ( '.$row['count'].' )'?><a href="<?=$row['area'].DS.$row['path'].DS ?>" class="secondary-content">
					<i class="material-icons" style="margin-top: 8px;">brightness_3</i></a>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>