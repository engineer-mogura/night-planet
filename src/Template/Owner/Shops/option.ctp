<div id="wrapper">
    <div class="container">
        <span id="dummy" style="display: hidden;"></span>
        <?= $this->Flash->render() ?>
        <h5><?=h('店舗設定') ?></h5>
        <!-- 編集中の店舗 START-->
        <?= $this->element('now_edit_shop'); ?>
        <!-- 編集中の店舗 END-->
        <div id="option" class="row">
            <div class="col s12 m12 l12 xl8">
                <div class="card-panel grey lighten-5">
                    <form id="save-option" name="save_option" method="post" action="/owner/shops/option?shop_id=<?= $shop->id ?>">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                        </div>
                        <div class="row scrollspy menu-colors-section">
                            <p>店舗メニュー色</p>
                            <ul>
                            <?php foreach ($mast_data['option_menu_color'] as $key => $value) {
                                $option->menu_color == $key ? $checked='checked':$checked='';
                                echo('<li class="color-'.$key.'">
                                        <input class="with-gap" type="radio" name="menu_color[]" id="'.$key.'" value="'.$key.'" '.$checked.'/>
                                        <label for="'.$key.'">'.$key.'</label>
                                    </li>');
                                }
                            ?>
                            </ul>
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