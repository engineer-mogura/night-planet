<div id="modal-login" class="modal">
    <div class="modal-content">
    <?= $this->Flash->render() ?>
      <p class="modal-login__modal-content__catch">お気に入りのお店やスタッフを登録して新着情報やスタッフブログを見逃さずにしよう‼</p>
      <div class="modal-login__modal-box">
        <div class="row">
          <?= $this->Form->create('null', array('url' => '/user/users/login')) ?>
            <div class="modal-login__modal-box__li-mail col s12 l12">
              <?= $this->Form->control('email', array('class'=>'modal-login__modal-box__li__input','placeholder'=>'メールアドレス','required' => false)) ?>
            </div>
            <div class="modal-login__modal-box__li-pass col s12 l12">
              <?= $this->Form->control('password', array('class'=>'modal-login__modal-box__li__input','placeholder'=>'パスワード','required' => false)) ?>
            </div>
            <div class="modal-login__modal-box__li-remember_me col s12 l12">
              <?= $this->Form->control('remember_me',['type'=>'checkbox','label'=>['text'=>'ログイン状態を保存する']]) ?>
            </div>
            <div class="modal-login__modal-box__li login col s12 l12">
                <?= $this->Form->button('ログイン',array('class'=>'modal-login__modal-box__li_btn-login btn waves-effect waves-light'));?>
            </div>
          <?= $this->Form->end() ?>
        </div>
        <div class="row">
          <div class="col s11">
            <ul>
              <li class="modal-login__modal-box__li signup">
                <a class="modal-login__modal-box__li_btn-signup btn waves-effect waves-light" href="/user/users/signup" name="action">
                  新規登録</a>
              </li>
              <li class="modal-login__modal-box__li forget">
                <a href="/user/users/pass_reset" class="modal-login__modal-box__li_btn-forget btn waves-effect waves-light" name="action">
                  パスワードをお忘れですか？</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer modal-login__modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
    </div>
  </div>