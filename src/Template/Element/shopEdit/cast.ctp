<div id="cast" class="col s12">
    <p>スタッフ<span><a href="" data-target="modal-help" data-help="3" class="modal-trigger edit-help"><i class="material-icons">help</i></a></span></p>
    <?php $count = 0;?>
    <?php foreach ($shop->casts as $key => $cast): ?>
        <?php if ($cast->registryAlias == 'tmps') : ?>
            <?php $count = ++$count; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($count > 0) : ?>
        <div class="card-panel red lighten-5"><?=$count . '件の承認待ちがあります。'?></div>
    <?php endif; ?>
    <div id="show-cast">
        <div class="row">
            <form id="delete-cast" name="delete_cast" method="post" style="display:none;"
                action="/owner/shops/delete_cast">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="dir" value="">
            </form>
            <?php foreach ($shop->casts as $key => $cast): ?>
                <div class="col s12 m6 l6 cast-box">
                    <div style="display:none;">
                        <input type="hidden" name="json_data" value='<?=$cast ?>'>
                    </div>
                    <ul class="collection z-depth-2 <?php if(count($shop->casts) == $key + 1) { echo('cast-Scroll');}?>">
                        <li class="collection-item">
                            <table class="highlight">
                                <thead>
                                    <tr>
                                        <td colspan="2">
                                            <span class="cast-num">スタッフ＃<?=$key + 1?></span>
                                            <?php if ($cast->delete_flag == 1) : ?>
                                                <span class="badge red darken-1 white-text"><?=承認待ち?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <img src="<?=$cast->icon?>" style="object-fit: cover;" alt="<?=$cast->name ?>" class="circle left" width="80" height="80">
                                            <input type="checkbox" class="check-cast-group" name="check_cast"
                                                id="check-cast<?=$key?>" />
                                            <label for="check-cast<?=$key?>">編集する</label>
                                            <div style="display:none;">
                                                <input type="hidden" name="json_data" value='<?=$cast ?>'>
                                            </div>
                                            <a href="#!" class="secondary-content">
                                                <div class="switch">
                                                    <label>OFF<input type="checkbox" value="<?=$cast->status ?>"
                                                            name="cast_switch<?=$cast->id ?>" class="cast-switchBtn"
                                                            <?php if ($cast->status == 1) { echo 'checked'; }?>><span
                                                            class="lever"></span>ON</label>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody class="tbody-cast-group">
                                    <tr>
                                        <th>名前</th>
                                        <td><?=$cast->name ?></td>
                                    </tr>
                                    <tr>
                                        <th>ニックネーム</th>
                                        <td><?=$cast->nickname ?></td>
                                    </tr>
                                    <tr>
                                        <th>メールアドレス</th>
                                        <td><?=$cast->email ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
            <div class="col s12 m12 l12">
                <?php if(count($shop->casts) == 0) { ?>
                <p>まだ登録されていません。</p>
                <button type="button" class="waves-effect waves-light btn-large cast-addBtn">登録</button>
                <?php } else { ?>
                <p style="text-align:center;">
                    <button type="button" class="waves-effect waves-light btn-large cast-addBtn">追加</button>
                    <button type="button" class="waves-effect waves-light btn-large disabled cast-changeBtn">変更</button>
                    <button type="button" class="waves-effect waves-light btn-large disabled cast-deleteBtn">削除</button>
                </p>
                <?php } ?>
            </div>
        </div>
    </div>
    <form id="save-cast" name="save_cast" method="post" action="/owner/shops/save_cast?shop_id=<?= $shop->id ?>" style="display:none;">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="crud_type" value="">
            <input type="hidden" name="id" value="">
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input type="text" id="cast-name" class="validate" name="name" data-length="50">
                <label for="cast-name">名前</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input type="text" id="cast-nickname" class="validate" name="nickname" data-length="50">
                <label for="cast-nickname">ニックネーム</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m10 l6">
                <input type="text" id="cast-email" class="validate" name="email" data-length="255">
                <label for="cast-email">メールアドレス</label>
            </div>
        </div>
        <div style="display:none;">
            <!-- TODO: 暫定でスタッフのパスワード初期値を決めている -->
            <input type="hidden" name="password" value="pass1234">
            <input type="hidden" name="role" value="cast">
        </div>
        <div class="card-content" style="text-align:center;">
            <button type="button" class="waves-effect waves-light btn-large cast-changeBtn">やめる</button>
            <button type="button" class="waves-effect waves-light btn-large cast-saveBtn">登録</button>
        </div>
    </form>
</div>