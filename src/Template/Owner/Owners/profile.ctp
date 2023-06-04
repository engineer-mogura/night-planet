<div id="wrapper">
    <div class="container">
        <div class="row">
            <?= $this->Flash->render() ?>
            <h5><?=('オーナー情報') ?></h5>
            <div class="col s12 m4 l4">
                <form id="save-image" name="save_image" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/owner/owners/saveProfile">
                    <div style="display:none;">
                        <input type="hidden" name="action_type" value="image">
                    </div>
                    <div class="col s12 ">
                        <div class="file-field card-panel grey lighten-5 input-field card-panel grey lighten-5 z-depth-1">
                            <div class="row valign-wrapper">
                                <div class="col s5 m5 l5">
                                    <img class="circle left" width="50" height="50" src="<?=$owner->icon ?>" alt="">
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
                    <a href="/owner/owners/passChange" class="waves-effect waves-light btn-large passChangeBtn">パスワード変更</a>
                </p>
            </div>

            <div id="profile" class="col s12 m8 l8">
                <span id="dummy" style="display: hidden;"></span>
                <div class="card-panel grey lighten-5">
                    <form id="save-profile" name="save_profile" method="post" action="/owner/owners/saveProfile/">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input type="text" id="name" class="validate" name="name" value="<?=$owner->name ?>" data-length="30">
                                <label for="name">名前</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input type="text" id="nickname" class="validate" name="nickname" value="<?=$owner->nickname ?>" data-length="30">
                                <label for="nickname">ニックネーム</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input type="text" id="email" class="validate" name="email" value="<?=$owner->email ?>" disabled>
                                <label for="email">Ｅメール</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input type="password" id="password" class="validate" name="password" value="<?=$owner->password ?>" disabled>
                                <label for="password">パスワード</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <select name="age">
                                    <option value="">年齢を選択してください</option>
                                    <?php foreach ($selectList['age'] as $key => $value) {
                                        $owner->age == $key ? $option = '<option value="'.$key.'" selected>'.$value.'</option>':$option = '<option value="'.$key.'">'.$value.'</option>';
                                        echo($option);
                                    }?>
                                </select>
                                <label>年齢</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input type="tel" id="tel" class="validate" name="tel" value="<?=$owner->tel ?>">
                                <label for="tel">電話番号</label>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="gender" value="">
                            <p>
                                <input type="radio" name="gender" value="1" id="gender-1" <?=$owner->gender == 1 ? "checked=checked":""?>legend="1">
                                <label for="gender-1">男</label>
                            </p>
                            <p>
                                <input type="radio" name="gender" value="0" id="gender-0" <?=$owner->gender == 0 ? "checked=checked":""?> legend="1">
                                <label for="gender-0">女</label>
                            </p>
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
