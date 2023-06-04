<div id="today-member-modal" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="row shop-menu section scrollspy">
			<p>本日の出勤メンバー(※予定)</p>
				<?php if((is_countable($shop->casts) ? count($shop->casts) > 0 : 0) && (is_countable($shop->work_schedules) ? count($shop->work_schedules) > 0 : 0)): ?>
					<?php $idsArr = explode(',', $shop->work_schedules[0]['cast_ids']);?>
					<?php foreach($shop->casts as $cast): ?>
						<?php if(!in_array($cast->id, $idsArr)) { continue; } ?>
						<div class="p-casts-section__list center-align col s3 m3 l3">
							<a href="<?=DS.$shop['area'].DS.PATH_ROOT['CAST'].DS.$cast['id']."?genre=".$shop['genre']."&name=".$shop['name']."&shop=".$shop['id']."&nickname=".$cast['nickname']?>">
								<img src="<?=$cast->icon?>" alt="<?=$cast->nickname?>" class="p-casts-section__list_img_circle circle">
							</a>
							<div class="p-casts-section__p-casts-section__list__icons">
								<?=isset($cast->new_cast) ? '<i class="material-icons icons__new-icon">fiber_new</i>':''?>
								<?=isset($cast->update_cast) ? '<i class="material-icons icons__update-icon">update</i>':''?>
							</div>
							<span class="p-casts-section__p-casts-section__list__name truncate"><?=$cast->nickname?></span>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
			<div class="">
				<p>本日の出勤メンバーが登録されていません。</p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">とじる</a>
	</div>
</div>