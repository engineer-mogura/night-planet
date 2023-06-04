<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Cast[]|\Cake\Collection\CollectionInterface $shops
*/
?>
<div id="wrapper">
<?= $this->element('modal/castListModal'); ?>
    <div class="container">
        <span id="dummy" style="display: hidden;"></span>
        <?= $this->Flash->render() ?>
        <h5><?=h('出勤管理') ?></h5>
        <!-- 編集中の店舗 START-->
        <?= $this->element('now_edit_shop'); ?>
        <!-- 編集中の店舗 END-->
        <span>〇：出勤可能 ✕：出勤不可 ー：未定</span>
            <div id="work-schedule-management" class="row">
                <!-- 出勤希望リスト START -->
                <div class="col s12 table-wrap">
                    <table class="striped centered" border="1">
                        <thead>
                            <tr class="tr-header">
                                <th align="center"><?=date('Y')?></th>
                                <?php 
                                    foreach ($dateList as $key => $date):
                                ?>
                                <th align="center"><?= $date ?></th>
                                <?php
                                    endforeach;
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php 
                                    foreach ($casts as $key => $cast):
                                ?>
                                <th align="center">
                                    <img src="<?= $cast->icon ?>" alt="" class="circle" width="50" height="50">
                                    </br><span class="center-align"><?=$cast['name']?></span>
                                </th>
                                <?php 
                                    foreach ($cast->scheduleInfo['workPlan'] as $key => $value):
                                ?>
                                        <td align="center"><?=$value?></td>
                                <?php
                                    endforeach;
                                ?>
                            </tr>
                                <?php
                                    endforeach;
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- 出勤希望リスト END -->
                <div class="col s12 center-align" style="margin-top: 20px;">
                <?php 
                    if(empty($casts)) :
                        echo ('スタッフが登録されていないか、表示ボタンがONになっていません。');
                    else :
                ?>
                    <a data-target="modal-cast-list" class="waves-effect waves-light btn modal-trigger jobModal-callBtn">本日のメンバーを選択する</a>

                <?php
                    endif;
                ?>

                </div>

            </div>
            <div class="row">
                <div class="col s12">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
