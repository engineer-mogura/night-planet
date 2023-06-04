<div id="wrapper">
    <?= $this->element('modal/calendarModal'); ?>
    <div class="container">
        <div class="row">
            <div id="dashboard" class="col">
                <span id="dummy" style="display: hidden;"></span>
                <?= $this->Flash->render() ?>
                <h5><?= $cast->name.'　所属：'?><a href="<?=$castInfo['shop_url']?>" target=”_blank” rel="noopener noreferrer"><?=$cast->shop->name?></a></h5>
                <p style="font-weight: bolder;">現在、一番下の出勤スケジュールのみが有効になります。</p>
                <div id="cast" class="row">
                    <div class="col s12 m4 l4">
                        <a href="/cast/casts/index">
                            <div class="card">
                                <div class="card-image">
                                    <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."favo.png"?>>
                                    <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">favorite</i></a>
                                </div>
                                <div class="card-content">
                                    <p class="dashboard__cast__card-content__p">お気に入りの数：<?=!empty($cast->cast_likes) ? $cast->cast_likes[0]->total : 0 ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col s12 m4 l4">
                        <a href="/cast/casts/index">
                            <div class="card">
                                <div class="card-image">
                                    <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."like1.png"?>>
                                    <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">thumb_up</i></a>
                                </div>
                                <div class="card-content">
                                    <p class="dashboard__cast__card-content__p">いいねの数：<?=!empty($cast->diary_likes) ? $cast->diary_likes[0]->total : 0 ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col s12 m4 l4">
                        <a href="/cast/casts/diary">
                            <div class="card">
                                <div class="card-image">
                                    <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."notebook1.png"?>>
                                    <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">mode_edit</i></a>
                                </div>
                                <div class="card-content">
                                    <p class="dashboard__cast__card-content__p">日記の投稿数：<?=!empty($cast->diarys) ? $cast->diarys[0]->total : 0 ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="card">
                            <div class="card-image">
                                <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."calendar1.png"?>>
                                <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">directions_run</i></a>
                            </div>
                            <div class="card-content">
                                <p class="dashboard__cast__card-content__p">出勤率：</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <p style="text-align: center;color: chocolate;">出勤希望日</p>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
