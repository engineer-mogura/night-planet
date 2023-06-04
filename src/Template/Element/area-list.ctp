<ul class="collapsible" data-collapsible="accordion">
	<li>
		<div class="collapsible-header">
			<i class="material-icons">zoom_in</i><?=REGION['okinawa']['label'].'　'.REGION['south']['label'].' ( '.$region['south'].' )'?>
		</div>
		<div class="collapsible-body">
			<ul class="collection with-header">
				<?php foreach ($area as $key => $value): ?>
					<?php if (REGION['south']['path'] == $value['region']): ?>
						<li class="collection-item linkbox">
							<div><?=$value['label'].'エリア ( '.$value['count'].' )'?><a href="<?=$value['path']?>" class="secondary-content">
								<i class="material-icons" style="margin-top: 8px;">location_on</i></a>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<li>
		<div class="collapsible-header">
			<i class="material-icons">zoom_in</i><?=REGION['okinawa']['label'].'　'.REGION['center']['label'].' ( '.$region['center'].' )'?>
		</div>
		<div class="collapsible-body">
			<ul class="collection with-header">
				<?php foreach ($area as $key => $value): ?>
					<?php if (REGION['center']['path'] == $value['region']): ?>
						<li class="collection-item linkbox">
							<div><?=$value['label'].'エリア ( '.$value['count'].' )'?><a href="<?=$value['path']?>" class="secondary-content">
								<i class="material-icons" style="margin-top: 8px;">location_on</i></a>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<li>
		<div class="collapsible-header">
			<i class="material-icons">zoom_in</i><?=REGION['okinawa']['label'].'　'.REGION['north']['label'].' ( '.$region['north'].' )'?>
		</div>
		<div class="collapsible-body">
			<ul class="collection with-header">
				<?php foreach ($area as $key => $value): ?>
					<?php if (REGION['north']['path'] == $value['region']): ?>
						<li class="collection-item linkbox">
							<div><?=$value['label'].'エリア ( '.$value['count'].' )'?><a href="<?=$value['path']?>" class="secondary-content">
								<i class="material-icons" style="margin-top: 8px;">location_on</i></a>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<li>
		<div class="collapsible-header">
			<i class="material-icons">zoom_in</i><?=REGION['miyakojima']['label'].' ( '.$region['miyakojima'].' )'?>
		</div>
		<div class="collapsible-body">
			<ul class="collection with-header">
				<?php foreach ($area as $key => $value): ?>
					<?php if (REGION['miyakojima']['path'] == $value['region']): ?>
						<li class="collection-item linkbox">
							<div><?=$value['label'].'エリア ( '.$value['count'].' )'?><a href="<?=$value['path']?>" class="secondary-content">
								<i class="material-icons" style="margin-top: 8px;">location_on</i></a>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<li>
		<div class="collapsible-header">
			<i class="material-icons">zoom_in</i><?=REGION['ishigakijima']['label'].' ( '.$region['ishigakijima'].' )'?>
		</div>
		<div class="collapsible-body">
			<ul class="collection with-header">
				<?php foreach ($area as $key => $value): ?>
					<?php if (REGION['ishigakijima']['path'] == $value['region']): ?>
						<li class="collection-item linkbox">
							<div><?=$value['label'].'エリア ( '.$value['count'].' )'?><a href="<?=$value['path']?>" class="secondary-content">
								<i class="material-icons" style="margin-top: 8px;">location_on</i></a>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
</ul>