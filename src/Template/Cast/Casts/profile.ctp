<div id="wrapper">
    <div class="container">
        <div class="row">
            <?= $this->Flash->render() ?>
            <h5><?=('スタッフ情報') ?></h5>
            <div class="col s12 m4 l4">
                <form id="save-image" name="save_image" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/cast/casts/saveProfile">
                    <div style="display:none;">
                        <input type="hidden" name="action_type" value="image">
                    </div>
                    <div class="col s12 ">
                        <div class="file-field card-panel grey lighten-5 input-field card-panel grey lighten-5 z-depth-1">
                            <div class="row valign-wrapper">
                                <div class="col s5 m5 l5">
                                    <img class="circle left" width="50" height="50" src="<?= $cast->icon ?>" alt="">
                                    <input type="file" id="image-file" accept="image/jpeg,image/png" name="image">
                                </div>
                                <div class="file-path-wrapper hide">
                                    <input class="file-path validate" name="file_path" type="text">
                                </div>
                                <div class="col s7 m7 l7">
                                    <a class="">プロフィール写真を変更する</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <canvas id="image-canvas" style="display:none;"></canvas>
                <p class="input-field col s12 m12 l12 center-align">
                    <a href="/cast/casts/passChange" class="waves-effect waves-light btn-large passChangeBtn">パスワード変更</a>
                </p>
            </div>
            <div id="profile" class="col s12 m8 l8">
                <span id="dummy" style="display: hidden;"></span>
                <?= $this->Flash->render() ?>
                <div class="card-panel grey lighten-5">
                    <form id="save-profile" name="save_profile" method="post" action="/cast/casts/saveProfile/">
                        <div style="display:none;">
                            <input type="hidden" name="json_data" value='<?= $cast ?>'>
                            <input type="hidden" name="_method" value="POST">
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="なるべく本名で入力してください。"><i class="material-icons">help</i></a>
                                </p>
                                <input type="text" id="name" class="validate" name="name" value="<?=$cast->name ?>" data-length="30">
                                <label for="name">名前</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="スタッフ紹介ページではこちらの名前で表示します。"><i class="material-icons">help</i></a>
                                </p>
                                <input type="text" id="nickname" class="validate" name="nickname" value="<?=$cast->nickname ?>" data-length="30">
                                <label for="nickname">ニックネーム</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="アドレスの変更はできません。どうしても変更が必要な場合はお問い合わせください。"><i class="material-icons">help</i></a>
                                </p>
                                <input type="text" id="email" class="validate" name="email" value="<?=$cast->email ?>" disabled>
                                <label for="email">Ｅメール</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="パスワードを変更する場合はパスワード変更からできます。"><i class="material-icons">help</i></a>
                                </p>
                                <input type="password" id="password" class="validate" name="password" value="<?=$cast->password ?>" disabled>
                                <label for="password">パスワード</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="スタッフ紹介では誕生日として表示します。例：12/24"><i class="material-icons">help</i></a>
                                </p>
                                <input type="text" id="birthday" class="birthday-picker" name="birthday">
                                <label>誕生日</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <p>
                                    <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="年齢が公開されることはありません。"><i class="material-icons">help</i></a>
                                </p>
                                <select name="age">
                                    <option value="">年齢を選択してください</option>
                                    <?php foreach ($selectList['age'] as $key => $value) {
                                        $cast->age == $key ? $option = '<option value="'.$key.'" selected>'.$value.'</option>':$option = '<option value="'.$key.'">'.$value.'</option>';
                                        echo($option);
                                    }?>
                                </select>
                                <label>年齢</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <select name="constellation">
                                    <option value="">星座を選択してください</option>
                                    <?php foreach ($selectList['constellation'] as $key => $value) {
                                        $cast->constellation == $key ? $option = '<option value="'.$key.'" selected>'.$value.'</option>':$option = '<option value="'.$key.'">'.$value.'</option>';
                                        echo($option);
                                    }?>
                                </select>
                                <label>星座</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <select name="blood_type">
                                    <option value="">血液型を選択してください</option>
                                    <?php foreach ($selectList['blood_type'] as $key => $value) {
                                        $cast->blood_type == $key ? $option = '<option value="'.$key.'" selected>'.$value.'</option>':$option = '<option value="'.$key.'">'.$value.'</option>';
                                        echo($option);
                                    }?>
                                </select>
                                <label>血液型</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <textarea id="message" class="validate materialize-textarea" name="message" data-length="50"><?=$cast->message ?></textarea>
                                <label for="message">メッセージ</label>
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
