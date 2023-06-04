<div id="wrapper">
    <div id="change-plan" class="container">
        <div class="row">
            <?= $this->Flash->render() ?>
            <div class="col s12 m12 l12">
                <h6><?=('プラン変更') ?></h6>
                <span id="dummy" style="display: hidden;"></span>
                <div class="col s12 m12 l12">
                    <table class="bordered shop-table z-depth-2" border="1">
                        <tbody>
                            <tr>
                                <th align="center">あなたの会員ステータス</th>
                                <td>
<?php
                                $is_free = true; // フリープランか
                                $start = $this->Time->format($owner->servece_plan->from_start, 'Y/M/d');
                                $end   = $this->Time->format($owner->servece_plan->to_end, 'Y/M/d');
                                $course = $owner->servece_plan->course;
                                SERVECE_PLAN[$owner->servece_plan->current_plan]['label'] != SERVECE_PLAN['free']['label'] ? 
                                        $is_free = false : null;
?>
                                    <?= !$is_free ? SERVECE_PLAN[$owner->servece_plan->current_plan]['name']
                                        .'　'.$course .'ヵ月コース' : SERVECE_PLAN[$owner->servece_plan->current_plan]['name'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th align="center">期間</th>
                                <td><?php if(!$is_free) {
                                    echo($start . ' ～ ' .$end);
                                } else {
                                    echo('期間制限なし');
                                } ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <a href="<?=PUBLIC_DOMAIN."/entry/#plan"?>" class="waves-effect waves-light btn-large red darken-1">プランの詳細はこちら</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="card plan-card orange darken-3">
                    <div class="card-content white-text">
                        <span class="card-title"><?=SERVECE_PLAN['basic']['name']?></span>
                        <ul>
                            <li>Instagramをページ内に埋め込むことが出来ます。最新の投稿を１２表示します。</li>
                            <li>エリアトップページのメイン広告を一定期間掲載いたします。※３ヵ月コースのみ</li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'basic'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '1'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['basic']['name'].'１ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('１ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'basic'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '3'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['basic']['name'].'３ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('３ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="card plan-card  grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><?=SERVECE_PLAN['premium']['name']?></span>
                        <ul>
                            <li>Instagram投稿数を５４に拡張します。</li>
                            <li>一部の店舗アクセスレポートを提供します。</li>
                            <li>エリアトップページのメイン広告を一定期間掲載いたします。※３ヵ月コースのみ</li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'premium'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '1'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['premium']['name'].'１ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('１ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'premium'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '3'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['premium']['name'].'３ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('３ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="card plan-card yellow darken-3">
                    <div class="card-content white-text">
                        <span class="card-title"><?=SERVECE_PLAN['premium_s']['name']?></span>
                        <ul>
                            <li>Instagram投稿数を１２０に拡張します。</li>
                            <li>店舗のアクセスレポートを提供します。</li>
                            <li>インスタグラムアカウントへのリンクを解放します。リンク解放のメリットは店舗様が運営されるInstagramへ誘導することができ、フォローしてくれる可能性がUPします。</li>
                            <li>エリアトップページのメイン広告を一定期間掲載いたします。※３ヵ月コースのみ</li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'premium_s'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '1'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['premium_s']['name'].'１ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('１ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                            <div class="col s6 m6 l6">
                                <?= $this->Form->create() ?>
                                <?= $this->Form->input('plan', array('type' => 'hidden',
                                    'value' => 'premium_s'));?>
                                <?= $this->Form->input('course', array('type' => 'hidden',
                                    'value' => '3'));?>
                                <?= $this->Form->input('message', array('type' => 'hidden',
                                    'value' => SERVECE_PLAN['premium_s']['name'].'３ヶ月コースでよろしいですか？'));?>
                                <?= $this->Form->button('３ヶ月コース',array('type' =>'submit', 'class'
                                    =>'waves-effect waves-light btn-large',$owner->is_range_plan ? "disabled":null));?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>