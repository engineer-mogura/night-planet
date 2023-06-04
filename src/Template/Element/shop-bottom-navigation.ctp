<?php isset($shop) ? $shop = $shop : $shop = $cast->shop ?>
<div class="bottom-sticky-nav z-depth-5">
    <ul>
        <li><a onClick="telme('<?=str_replace('_shopname_', $shop->name, CONFIRM_M['TEL_ME'])?>','<?=$shop->tel?>')"><i class="material-icons">local_phone</i><span>TEL</span></a></li>
        <li><a href="#" ><i class="material-icons">add_alert</i><span>お知らせ</span></a></li>
        <li><a class="modal-trigger" href="#shop-sharer-modal"><i class="material-icons">share</i><span>シェア</span></a></li>
        <?= $next_view == PATH_ROOT['SHOP'] ? 
            '<li><a href="#menu-section"><i class="material-icons">arrow_upward</i><span>SHOP MENU</span></a></li>'
            :
             '<li><a href="#html-header"><i class="material-icons">arrow_upward</i><span>上に行く</span></a></li>'

        ?>
    </ul>
</div>