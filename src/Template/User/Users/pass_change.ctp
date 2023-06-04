<div id="wrapper">
    <div class="container">
        <?= $this->Flash->render() ?>
        <h5><?=('パスワード変更') ?></h5>
        <span id="dummy" style="display: hidden;"></span>
        <div class="card-panel grey lighten-5">
            <p>パスワードは大文字小文字を混在させた８文字以上、３２文字以内で入力してください。</p>
            <div class="card-image waves-block waves-light">
                <div class="or-form-wrap">
                    <?= $this->Form->create($owner) ?>
                    <?= $this->Form->control('password', array('type'=>'password','label'=>'現在のパスワード')) ?>
                    <p><a href="/owner/owners/pass_reset">パスワードをお忘れですか？</a></p>
                    <br>
                    <?= $this->Form->control('password_new', array('type'=>'password','label' => '新しいパスワード')) ?>
                    <div class="or-button">
                        <?= $this->Form->button('パスワード変更',array('type' =>'submit','class'=>'waves-effect waves-light btn-large'));?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>