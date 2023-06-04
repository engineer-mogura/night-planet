<div id="wrapper">
    <div class="container">
        <div class="row">
            <?= $this->Flash->render() ?>
            <h5><?=('SNS') ?></h5>
            <div id="sns" class="col s12 m8 l8">
                <span id="dummy" style="display: hidden;"></span>
                <div class="card-panel grey lighten-5">
                    <form id="save-sns" name="save_sns" method="post" action="/cast/casts/sns/">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="facebook" class="validate" name="facebook" value="<?=!empty($cast->snss[0]->facebook) ? $cast->snss[0]->facebook:"" ?>" data-length="255">
                                <label for="facebook">facebook</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="twitter" class="validate" name="twitter" value="<?=!empty($cast->snss[0]->twitter) ? $cast->snss[0]->twitter:"" ?>" data-length="255">
                                <label for="twitter">twitter</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="instagram" class="validate" <?=$castInfo['current_plan'] != SERVECE_PLAN['premium_s']['label'] ? ' disabled ' : null ?> name="instagram" value="<?=!empty($cast->snss[0]->instagram) ? $cast->snss[0]->instagram:"" ?>" data-length="255">
                                <label for="instagram">instagram</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="line" class="validate" disabled name="line" value="<?=!empty($cast->snss[0]->line) ? $cast->snss[0]->line:"" ?>" data-length="255">
                                <label for="line">line</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <button type="submit" class="waves-effect waves-light btn-large disabled saveBtn right">登録</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
