<div id="modal-job" class="modal">
    <div class="modal-content">
        <h5>待遇タグ一覧</h5>
        <p>複数選択できます</p>
        <div class="chip-box">
            <?php foreach ($selectList['treatment'] as $key => $value): ?>
            <div class="chip-dummy chip-treatment" name=""id="<?=$key?>" value="<?=$value?>"><?=$value?></div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
    </div>
</div>