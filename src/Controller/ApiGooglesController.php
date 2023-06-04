<?php
namespace App\Controller;

use Cake\Log\Log;
use Google_Client;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Error\Debugger;
use Cake\Controller\Component;
use Google\ApiCore\ApiException;
use App\Controller\AppController;
use Cake\Controller\ComponentRegistry;
use Google\Analytics\Data\V1beta as Google;
use App\Controller\Component\BatchComponent;

class ApiGooglesController extends AppController
{
    /**
     * Undocumented function 保守用
     *
     * @return void
     */
    public function index($isHosyu, $isZenjitsu = null, $startDate = null, $endDate = null)
    {

        // 自動レンダリングを OFF
        $this->render(false, false);

        // アナリティクスのプロパティ
        $gaProperty =  env('GOOGLE_ANALYTICS_GA4_ID', null);
        // デフォルトのコンストラクターを使用すると、クライアントに資格情報を使用するよう指示します
        // GOOGLE_APPLICATION_CREDENTIALS 環境変数で指定
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . CONFIG . 'googles/service-account-credentials.json');

        $client = new Google\BetaAnalyticsDataClient();

        // 保守用一括登録処理の場合
        if ($isHosyu) {

            $start = $startDate; // 開始日
            $end   = $endDate; // 終了日

            Log::info(__LINE__ . '::' . __METHOD__ 
                . "::保守用一括登録処理,開始日：". $start . "終了日：". $end , "batch_ar");

            $moto_start_date = date($start);
            $moto_end_date = date($end);

            // コンポーネントを参照(コンポーネントを利用する場合)
            $this->Batch = new BatchComponent(new ComponentRegistry());
            $is = true;
            $count = 0;

            while ($is) {
                $startDate = date("Y-m-d",strtotime($moto_start_date . "+" . $count . " day"));
                $endDate = date("Y-m-d",strtotime($moto_start_date . "+" . $count . " day"));

                // Call the Analytics Reporting API V4.
                try {
                    $reports = $this->getReport($client, $startDate, $endDate, $gaProperty);
                } catch (ApiException $e) {
                    Log::error(__LINE__ . '::' . __METHOD__ . '::'.'【Call failed with message: %s'
                        . PHP_EOL, $e->getMessage(), "batch_ar");
                }

                // タスクの実行
                $result = $this->Batch->calculateAnalyticsReport($reports,  $startDate);
                //$today = date("Y-m-d");
                if (strtotime($startDate) === strtotime($moto_end_date)) {
                    $is = false;
                }
                $count++;
            }
            Log::info(__LINE__ . '::' . __METHOD__ . "::". $startDate . '~' . $endDate . ' ' . $count . '日分処理しました。', "batch_ar");

        } else {
            if ($isZenjitsu) {
                // 前日登録処理の場合
                $zenDate   = new Time(date('Y-m-d'));
                $zenDate   = $zenDate->subDays(1);
                $startDate = $zenDate->format("Y-m-d");
                $endDate   = $zenDate->format("Y-m-d");
            } else {
                // 通常登録処理の場合
                $startDate = date("Y-m-d");
                $endDate   = date("Y-m-d");
            }
            try {
                $reports = $this->getReport($client, $startDate, $endDate, $gaProperty);
            } catch (ApiException $e) {
                Log::error(__LINE__ . '::' . __METHOD__ . '::'.'【Call failed with message: %s'
                    . PHP_EOL, $e->getMessage(), "batch_ar");
            }

            return $reports;
        }

    }

    /**
     * Queries the Analytics Reporting API V4.
     *
     * @param service An authorized Analytics Reporting API V4 service object.
     * @return The Analytics Reporting API V4 response.
     */
    public function getReport($client, $startDate, $endDate, $gaProperty)
    {
        /**
         * dimension filter を作成
         */
        $area = "";
        // エリア
        foreach (AREA as $index => $value) {
            if ($index === array_key_first(AREA)) {
                $area .= "/(";
            }
            $area .= $value['path'] . '|';
            if ($index === array_key_last(AREA)) {
                $area .= ")";
                $area = str_replace('|)', ')', $area);
            }
        }
        $genre = "";
        // スタッフとジャンル
        foreach (GENRE as $index => $value) {
            if ($index === array_key_first(GENRE)) {
                $genre .= "/(cast|";
            }
            $genre .= $value['path'] . '|';
            if ($index === array_key_last(GENRE)) {
                $genre .= ")/[0-9]{1,9}$";
                $genre = str_replace('|)', ')', $genre);
            }
        }
        $dimensionFilter = $area . $genre;

        $response = $client->runReport([
            'property' => 'properties/' . $gaProperty,
            'dateRanges' => [
                new Google\DateRange([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]),
            ],
            'dimensions' => [
                new Google\Dimension([
                    'name' => 'date',
                ]),
                new Google\Dimension([
                    'name' => 'pageTitle',
                ]),
                new Google\Dimension([
                    'name' => 'pagePath',
                ]),
                new Google\Dimension([
                    'name' => 'landingPagePlusQueryString',
                ]),
                new Google\Dimension([
                    'name' => 'dayOfWeek',
                ]),
                new Google\Dimension([
                    'name' => 'dayOfWeekName',
                ]),
            ],
            'dimensionFilter' =>
                new Google\FilterExpression([
                    'filter' => new Google\Filter([
                        'field_name' => 'pagePath',
                        'string_filter' => new Google\Filter\StringFilter([
                            'match_type' => Google\Filter\StringFilter\MatchType::PARTIAL_REGEXP,
                            'value' => $dimensionFilter
                        ]),
                    ]),
                ]),
                // // キャスト,日記,お知らせ画面を対象外にする
                // new Google\FilterExpression([
                //     'not_expression' => new Google\FilterExpression([
                //         'filter' => new Google\Filter([
                //             'field_name' => 'pagePath',
                //             'string_filter' => new Google\Filter\StringFilter([
                //                 'match_type' => Google\Filter\StringFilter\MatchType::PARTIAL_REGEXP,
                //                 'value' => '\/.*(cast|diary|notice).*\/',// ^(\/ignore|\/except).*
                //             ]),
                //         ]),
                //     ])
                // ]),
            'metrics' => [
                new Google\Metric([
                    'name' => 'screenPageViews',
                ]),
                new Google\Metric([
                    'name' => 'newUsers',
                ]),
                new Google\Metric([
                    'name' => 'activeUsers',
                ]),
                new Google\Metric([
                    'name' => 'sessions',
                ]),
            ],
            'orderBys' => [
                new Google\OrderBy([
                    'metric' => new Google\OrderBy\MetricOrderBy([
                        'metric_name' => 'sessions',
                    ]),
                    'desc' => true,
                    // 'dimension' => new Google\OrderBy\DimensionOrderBy([
                    //     'dimension_name' => 'dayOfWeek',
                    //     'order_type' => Google\OrderBy\DimensionOrderBy\OrderType::NUMERIC
                    // ]),
                    // 'desc' => true,
                ]),
            ],
        ]);
        $format = "\r\n【date : %s 】\r\n【pageTitle : %s 】\r\n【pagePath : %s 】\r\n【landingPagePlusQueryString : %s 】\r\n【dayOfWeek : %s 】\r\n【dayOfWeekName : %s 】\r\n【screenPageViews : %s 】\r\n【newUsers : %s 】\r\n【activeUsers : %s 】\r\n【sessions : %s 】";
        foreach ($response->getRows() as $row) {
            $this->log(sprintf($format,
                                $row->getDimensionValues()[0]->getValue(),
                                $row->getDimensionValues()[1]->getValue(),
                                $row->getDimensionValues()[2]->getValue(),
                                $row->getDimensionValues()[3]->getValue(),
                                $row->getDimensionValues()[4]->getValue(),
                                $row->getDimensionValues()[5]->getValue(),
                                $row->getMetricValues()[0]->getValue(),
                                $row->getMetricValues()[1]->getValue(),
                                $row->getMetricValues()[2]->getValue(),
                                $row->getMetricValues()[3]->getValue()
                            )
                    , 'debug');
        }
        return $response;
    }

}
