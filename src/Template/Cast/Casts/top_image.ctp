<div id="wrapper">
    <span id="dummy" style="display: hidden;"></span>
    <div class="container">
        <div class="row">
            <div id="top-image" class="col s12 m8 l6">
                <?php echo $this->Flash->render(); ?>
                <h5><?=('トップ画像') ?></h5>
                <div id="show-top-image" style="text-align:center">
                    <img width="100%" height="300" src="<?= $cast->top_image ?>" />
                    <button type="button" class="waves-effect waves-light btn-large changeBtn">変更</button>
                </div>
                <form id="save-top-image" name="save_top_image" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/cast/casts/save_top_image" style="display:none;">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST">
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" id="top-image-file" name="top_image_file" onChange="imgDisp();">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" name="top_image" type="text">
                        </div>
                    </div>
                    <img src="" id="top-image-show" />
                    <img src="" id="top-image-preview" class="top-image-preview" style="display:none;" />
                    <canvas id="top-image-canvas" style="display:none;"></canvas>
                    <div class="card-content" style="text-align:center;">
                        <button type="button" class="waves-effect waves-light btn-large changeBtn">やめる</button>
                        <button type="button" class="waves-effect waves-light btn-large saveBtn">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>