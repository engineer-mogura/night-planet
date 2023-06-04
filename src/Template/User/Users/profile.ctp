<div id="wrapper">
    <div id="user" class="container">
        <div class="row">
            <?= $this->element('nav-breadcrumb'); ?>
            <?= $this->Flash->render() ?>
            <div id="user-main" class="col s12 m4 l4">
                <form id="save-image" name="save_image" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="/user/users/saveProfile">
                    <div style="display:none;">
                        <input type="hidden" name="action_type" value="image">
                    </div>
                    <div class="col s12 ">
                        <div class="file-field card-panel grey lighten-5 input-field card-panel grey lighten-5 z-depth-1">
                            <div class="row valign-wrapper">
                                <div class="col s5 m5 l5">
                                    <img class="circle left" width="50" height="50" src="<?=$this->User->get_u_info('icon')?>" alt="">
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
                    <a href="/user/users/passChange" class="waves-effect waves-light btn-large passChangeBtn">パスワード変更</a>
                </p>
            </div>

            <div id="profile" class="col s12 m8 l8">
                <span id="dummy" style="display: hidden;"></span>
                <div class="card-panel grey lighten-5">
                    <form id="save-profile" name="save_profile" method="post" action="/user/users/saveProfile/">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input type="text" id="name" class="validate" name="name" value="<?=$user->name ?>" data-length="30">
                                <label for="name">名前</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input type="text" id="email" class="validate" name="email" value="<?=$user->email ?>" disabled>
                                <label for="email">Ｅメール</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input type="password" id="password" class="validate" name="password" value="<?=$user->password ?>" disabled>
                                <label for="password">パスワード</label>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="gender" value="">
                            <p>
                                <input type="radio" name="gender" value="1" id="gender-1" <?=$user->gender == 1 ? "checked=checked":""?>legend="1">
                                <label for="gender-1">男</label>
                            </p>
                            <p>
                                <input type="radio" name="gender" value="0" id="gender-0" <?=$user->gender == 0 ? "checked=checked":""?> legend="1">
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
