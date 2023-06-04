<?= $this->Html->css('rateit.css') ?>
<?= $this->Html->script('jquery.rateit.min.js') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!-- レビューモーダル START -->
<?= $this->element('modal/reviewModal'); ?>
<!-- レビューモーダル END -->
<div id="review" class="container">
    <?= $this->Flash->render() ?>
    <?= $this->element('nav-breadcrumb'); ?>
    <div class="row">
        <div class="col s12 m12 l8">
            <span id="dummy" style="display: hidden;"></span>
            <div class="row chart-section">
                <div class="col s12 m12 l12">
                    <div class="card-panel year-graph-shop section">
                        <!--描画箇所 -->
                        <canvas id="review-chart" height="300"></canvas>
                        <!--凡例箇所 -->
                        <ul id="chart_legend"></ul>
                        <div class="total-review center-align">
                            <p>総合評価</p>
                            <div id="total_review" class="rateit">
                            </div>
                            <span class="total_review-num"></span>
                        </div>
                    </div>
                    <div class="review-btn-section center-align">
                        <?=$this->User->get_comment_html('comment_write', $shop)?>
                        </a>
                    </div>
                    <div class="row section other-review-section">
                        <div class="light-blue accent-2 card-panel col s12 center-align">
                            <p class="event-label section-label"><span> 口コミ一覧 </span></p>
                        </div>
                        <div class="col s12 m12 l12">
                            <ul class="collection other-review-section__ul">
                                <?=$this->element('review-list')?>
                            </ul>
                            <div class="review-more-btn-section center-align">
                                <a class="yellow darken-4 waves-effect waves-green btn see_more_reviews"
                                     data-type='see_more_reviews' data-action=<?=DS.$this->request->url?>>もっと見る
                                </a>
                            </div>
                            <span class="paging" style="float:right"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--デスクトップ用 サイドバー START -->
        <?= $this->element('sidebar'); ?>
        <!--デスクトップ用 サイドバー END -->
    </div>
</div>
<?= $this->element('photoSwipe'); ?>
<!-- ショップ用ボトムナビゲーション START -->
<?= $this->element('shop-bottom-navigation'); ?>
<!-- ショップ用ボトムナビゲーション END -->

<script>

    /**
     * レビューグラフ作成
     */
    var reviewChart = function (data) {
        $('.total_review-num').text((Number(data['total_review']).toFixed(2)));
        $("#total_review").rateit({
            readonly: true,
            value: data['total_review'],
            max: 5,
        });
        var ctx = document.getElementById('review-chart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: ['コスパ', '店内雰囲気', '客層', 'スタッフ', '清潔感'], 
                datasets: [{
                    label: '口コミレビュー',
                    backgroundColor: 'rgb(255, 0, 0, 0.5)',
                    borderColor: 'rgb(255, 99, 132, 0.5)',
                    borderWidth: 2,
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "rgba(201,60,58,0.8)",
                    pointBorderWidth: 2,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#9A1B19",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 2,
                    tension: 0,
                    data: [Number(data['cost_star']).toFixed(2)
                        , Number(data['atmosphere_star']).toFixed(2)
                        , Number(data['customer_star']).toFixed(2)
                        , Number(data['staff_star']).toFixed(2)
                        , Number(data['cleanliness_star']).toFixed(2)]
                }]
            },
            options: {
                responsive: true,
                // maintainAspectRatio: false,
                // 各種設定の記述
            }

        });
    }
    var totalReview  = JSON.parse('<?php echo ($shop['total_review']); ?>');
    reviewChart(totalReview);

    /** 
     * レビュー件数を表示する
     */
    var all_favo = '<?php echo ($all_favo); ?>';
    (function (all_favo) {
        var count = $('.other-review-section__ul__li').length;
        $('.paging').text(count + '/' + all_favo);
    }(all_favo));

    /** 
     * レビューを更に表示する
     */
    $('.truncate__show__review').click(function () {
        if ($(this).hasClass('truncate')) {
            $(this).removeClass('truncate');
        } else {
            $(this).addClass('truncate');
        }
    });

</script>
