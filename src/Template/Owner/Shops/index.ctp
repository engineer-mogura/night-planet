<div id="wrapper">
    <div id="dash-board" class="container">
        <span id="dummy" style="display: hidden;"></span>
        <div class="row">
            <div class="col s12 m12 l12">
                <!-- 編集中の店舗 START-->
                <?= $this->element('now_edit_shop'); ?>
                <!-- 編集中の店舗 END-->
            </div>
            <div class="white card-panel col s12 center-align">
                <p class="recruit-label section-label"><span> 店舗 </span></p>
            </div>
            <?php
                if($reports['access_years'] == '[]'
                    && $reports['access_months'] == '[]'
                    && $reports['access_weeks'] == '[]'):
            ?>
            <div class="col year-graph-section section">
                <p>登録して数日はアクセスデータがありません。数日経ってからご確認下さい。</p>
            </div>
            <?php
                endif;
            ?>
            <?php
                if($reports['access_years'] != '[]'):
            ?>
            <div class="col s12 m6 l6 year-graph-section section">
                <div class="card-panel year-graph-shop section">
                    <div class="input-field col s12">
                        <select id="range-y">
                            <option value="" disabled selected><?=$reports['ranges'][0][0]?></option>
                            <?php  foreach ($reports['ranges'][0] as $key => $value) {
                                echo ('<option value="'. $value .'">'. $value .'</option>');
                            } ?>
                        </select>
                        <label>選択</label>
                    </div>
                    <canvas id="shopYearChart" height="300"></canvas>
                    <input data-shop_year="" type="hidden" name="shop_year_data">
                </div>
            </div>
            <?php
                else:
            ?>
            <div class="col year-graph-section section">
                <p>年別アクセスデータがありません。数日経ってからご確認下さい。</p>
            </div>
            <?php
                endif;
            ?>
            <?php
                if($reports['access_weeks'] != '[]'):
            ?>
            <div class="col s12 m6 l6 year-graph-section section">
                <div class="card-panel year-graph-shop section">
                    <!--描画箇所 -->
                    <canvas id="shopWeekChart" height="300"></canvas>
                    <!--凡例箇所 -->
                    <ul id="chart_legend"></ul>
                </div>
            </div>
            <?php
                else:
            ?>
            <div class="col year-graph-section section">
                <p>曜日別アクセスデータがありません。数日経ってからご確認下さい。</p>
            </div>
            <?php
                endif;
            ?>
            <?php
                if($reports['access_months'] != '[]'):
            ?>
            <div class="col s12 m6 l6 day-graph-section section">
                <div class="card-panel day-graph-shop section">
                    <div class="input-field col s12">
                        <select id="range-ym">
                            <option value="" disabled selected><?=$reports['ranges'][1][0]?></option>
                            <?php  foreach ($reports['ranges'][1] as $key => $value) {
                                echo ('<option value="'. $value .'">'. $value .'</option>');
                            } ?>
                        </select>
                        <label>選択</label>
                    </div>
                    <!--描画箇所 -->
                    <canvas id="shopMonthChart" height="500"></canvas>
                    <!--凡例箇所 -->
                    <input data-shop_month="" type="hidden" name="shop_month_data">
                </div>
            </div>
            <?php
                else:
            ?>
            <div class="col day-graph-section section">
                <p>月別アクセスデータがありません。数日経ってからご確認下さい。</p>
            </div>
            <?php
                endif;
            ?>
            <div class="white card-panel col s12 center-align">
                <p class="recruit-label section-label"><span> スタッフ </span></p>
            </div>
            <?php 
                if(count($reports['ranges'][0][0]) == 0 ):
            ?>
            <div class="col year-graph-section section">
                <p>スタッフアクセスレポートは現在機能を停止中です。近日中に機能を再開いたしますので、それまでしばらくお待ちください。</p>
            </div>
            <?php
                else:
            ?>
            <div class="col s12">
                <p style="font-weight: bolder;">
                スタッフアクセスレポートは現在機能を停止中です。近日中に機能を再開いたしますので、それまでしばらくお待ちください。以下のグラフはダミーデータになります。</p>
            </div>
            <div class="col s12 m6 l6 day-graph-section section">
                <div class="card-panel day-graph-cast section">
                    <!--描画箇所 -->
                    <canvas id="castWeekChart" height="300"></canvas>
                    <!--凡例箇所 -->
                </div>
            </div>
            <div class="col s12 m6 l6 day-graph-section section">
                <div class="card-panel total-graph-cast section">
                    <!--描画箇所 -->
                    <canvas id="castTotalChartCast" height="300"></canvas>
                    <!--凡例箇所 -->
                </div>
            </div>
            <?php
                endif;
            ?>
            <div class="white card-panel col s12 center-align">
                <p class="recruit-label section-label"><span> その他 </span></p>
            </div>
            <div id="cast" class="row">
            <div class="col s12 m4 l4">
                <a href="/owner/shops/index">
                    <div class="card">
                        <div class="card-image">
                            <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."favo.png"?>>
                            <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">favorite</i></a>
                        </div>
                        <div class="card-content">
                            <p class="dashboard__cast__card-content__p">お気に入りの数：<?=!empty($cast->cast_likes) ? $cast->cast_likes[0]->total : 0 ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col s12 m4 l4">
                <a href="/owner/shops/index">
                    <div class="card">
                        <div class="card-image">
                            <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."like1.png"?>>
                            <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">thumb_up</i></a>
                        </div>
                        <div class="card-content">
                            <p class="dashboard__cast__card-content__p">いいねの数：<?=!empty($cast->diary_likes) ? $cast->diary_likes[0]->total : 0 ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col s12 m4 l4">
                <a href="/owner/shops/notice">
                    <div class="card">
                        <div class="card-image">
                            <img src=<?=PATH_ROOT['URL_S3_BUCKET'].DS.PATH_ROOT['OTHERS'].DS."notebook1.png"?>>
                            <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">mode_edit</i></a>
                        </div>
                        <div class="card-content">
                            <p class="dashboard__cast__card-content__p">お知らせの投稿数：<?=!empty($cast->diarys) ? $cast->diarys[0]->total : 0 ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<script>


    /**
     * 曜日別アクセス状況作成
     */
    var shopWeekChart = function (accessWeeks) {

        // データセット
        var data = [
            accessWeeks[0]['monday_pageviews'], accessWeeks[0]['tuesday_pageviews']
            , accessWeeks[0]['wednesday_pageviews'], accessWeeks[0]['thursday_pageviews']
            , accessWeeks[0]['friday_pageviews'], accessWeeks[0]['saturday_pageviews']
            , accessWeeks[0]['sunday_pageviews']
        ]
        var ctx = document.getElementById("shopWeekChart");
        var shopWeekChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["月曜", "火曜", "水曜", "木曜", "金曜", "土曜", "日曜"],
                datasets: [{
                    backgroundColor: [
                        "#ff8cd1", "#00ec5f", "#ffeb00", "#1995ff",
                        "#ff8303", "#ff0000", "#d800ff"
                    ],
                    data: data
                }]
            },
            options: {
                title: {
                    display: true,
                    text: ['曜日別 割合',
                    ]
                }
            }
        });
    }

    /**
    * 月間別アクセス状況作成
    */
    var shopYearChart = function (accessYears/*, rangeYears*/) {

        var data = [];
        var label = [];
        // データセット
        for (var i = 1; i <= 12; i++) {
            data.push(accessYears[i + '_pageviews']);
            label.push(i + ' 月');
        }

        //全データ格納用
        var allData = {};
        // 年月分割
        for (var i = 0; i < accessYears.length; i++) {

            var span = accessYears[i]['y'];
            var data = [];
            var label = [];
            // データセット
            for (var j = 1; j <= 12; j++) {
                data.push(accessYears[i][j + '_pageviews']);
                label.push(j + ' 月');
            }
            allData[span] = {'data' : data, 'label' : label, 'span' : span};
        }
        $('input').data('shop_year', allData);

        var nowY = accessYears[0]['y'];
        var ctx = document.getElementById('shopYearChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: allData[nowY].label,
                datasets: [{
                    label: '月間アクセス状況',
                    backgroundColor: 'rgb(255, 25, 102)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: allData[nowY].data,
                }]
            },

            // Configuration options go here
            options: {
                title: {
                    display: true,
                    text: allData[nowY].span,
                }
            }
        });

        $("#range-y").change(function(){
            var y = $(this).val();
            var data = $('input[name="shop_year_data"]').data()['shop_year'][y];
            chart.data.labels = data.label;
            chart.data.datasets[0].data = data.data;
            chart.options.title.text = data.span;
            chart.update();
        });
    }

    /**
     * 日別アクセス状況作成
     */
    var shopMonthChart = function (accessMonths/*, rangeMonths*/) {

        //全データ格納用
        var allData = {};
        // 年月分割
        for (var i = 0; i < accessMonths.length; i++) {
            var arrayYm = accessMonths[i]['ym'].split('-');
            var howManyDays = new Date(arrayYm[0], arrayYm[1], 0).getDate();
            var span = arrayYm[1] + " 月 1 日 ～ "
                + arrayYm[1] + " 月 " + howManyDays + " 日";
            var data = [];
            var label = [];
            // データセット
            for (var j = 1; j <= howManyDays; j++) {
                data.push(accessMonths[i][j + '_pageviews']);
                label.push(j + ' 日');
            }
            var ym = accessMonths[i].ym;
            allData[ym] = {'data' : data, 'label' : label, 'span' : span};
        }
        $('input').data('shop_month', allData);

        var nowYm = accessMonths[0]['ym'];
        var ctx = document.getElementById('shopMonthChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'horizontalBar',

            // The data for our dataset
            data: {
                labels: allData[nowYm].label,
                datasets: [{
                    label: '日別アクセス状況',
                    backgroundColor: 'rgb(255, 140, 0)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: allData[nowYm].data,
                }]
            },
            options: {
                title: {
                    display: true,
                    text: allData[nowYm].span,
                }
                // responsive: true,
                // maintainAspectRatio: false,
                // 各種設定の記述
            }

        });

        $("#range-ym").change(function(){
            var ym = $(this).val();
            var data = $('input[name="shop_month_data"]').data()['shop_month'][ym];
            chart.data.labels = data.label;
            chart.data.datasets[0].data = data.data;
            chart.options.title.text = data.span;
            chart.update();
        });
    }
    /**
     * 週別アクセス状況作成
     */
    var castWeekChart = function () {

        var ctx = document.getElementById('castWeekChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'horizontalBar',

            // The data for our dataset
            data: {
                labels: ['ユーザー１', 'ユーザー２', 'ユーザー３', 'ユーザー４', 'ユーザー５'],
                datasets: [{
                    label: '週別アクセス状況',
                    backgroundColor: 'rgb(255, 25, 102)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: ['９月３０～１０月６日',
                    ]
                }
                // responsive: true,
                // maintainAspectRatio: false,
                // 各種設定の記述
            }

        });
    }

    /**
     * 週別アクセス状況作成
     */
    var castTotalChartCast = function () {

        var ctx = document.getElementById('castTotalChartCast').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'horizontalBar',

            // The data for our dataset
            data: {
                labels: ['ユーザー１', 'ユーザー２', 'ユーザー３', 'ユーザー４', 'ユーザー５'],
                datasets: [{
                    label: 'トータルアクセス状況',
                    backgroundColor: 'rgb(255, 25, 102)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20]
                }]
            },
            options: {
                // responsive: true,
                // maintainAspectRatio: false,
                // 各種設定の記述
            }

        });
    }
    var accessYears  = JSON.parse('<?php echo ($reports['access_years']); ?>');
    var accessMonths = JSON.parse('<?php echo ($reports['access_months']); ?>');
    var accessWeeks  = JSON.parse('<?php echo ($reports['access_weeks']); ?>');
    // var rangeYears   = JSON.parse('<?php echo ($ranges['range_years']); ?>');
    // var rangeMonths  = JSON.parse('<?php echo ($ranges['range_months']); ?>');

    if(accessYears.length > 0) {
        shopYearChart(accessYears/*, rangeYears*/);
    }
    if(accessMonths.length > 0) {
        shopMonthChart(accessMonths/*, rangeMonths*/);
    }
    if(accessWeeks.length > 0) {
        shopWeekChart(accessWeeks);
    }
    // スタッフは停止中
    if (false) {castWeekChart()}
    castWeekChart();
    if (false) {castTotalChartCast()}
    castTotalChartCast();
    $(document).ready(function () {
        $(".card-panel").css("padding", "5px");
    });

</script>