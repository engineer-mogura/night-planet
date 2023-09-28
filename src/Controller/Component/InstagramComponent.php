<?php

namespace App\Controller\Component;

use Cake\Filesystem\Folder;
use Cake\Controller\Component;

class InstagramComponent extends Component {

    public $components = ['Instagram'];

    /**
     * インスタAPIにアクセスし情報を取得する処理
     *
     * @param [type] $insta_user_name
     * @param [type] $insta_business_name
     * @param [type] $insta_business_id
     * @param [type] $access_token
     * @return $instagram_data
     */
    public function getInstagram(
        $insta_user_name = null,
        $insta_business_name = null,
        $current_plan = null,
        $cache_path,
        $dat_file_name
    ) {

        //////////////////////
        /*     初期設定     */
        //////////////////////

        // 投稿の最大取得数
        $max_posts      = API['INSTAGRAM_MAX_POSTS'];

        // Graph API の URL
        $graph_api      = API['INSTAGRAM_GRAPH_API'];

        // ビジネスID
        $ig_buisiness   = API['INSTAGRAM_BUSINESS_ID'];

        // 無期限のページアクセストークン
        $access_token   = API['INSTAGRAM_GRAPH_API_ACCESS_TOKEN'];

        //ここに取得したいInstagramビジネスアカウントのユーザー名を入力してください。
        //https://www.instagram.com/nightplanet91/なので
        //「nightplanet91」がユーザー名になります
        $target_user    = $insta_user_name;

        // キャッシュ時間の設定 (最短更新間隔 [sec])
        // 更新頻度が高いと Graph API の時間当たりの利用制限に引っかかる可能性があるので、30sec以上を推奨
        $cache_lifetime = API['INSTAGRAM_CACHE_TIME'];

        // 表示形式の初期設定 (グリッド表示の時は 'grid'、一覧表示の時は 'list' を指定)
        $show_mode      = API['INSTAGRAM_SHOW_MODE'];

        // プラン情報により、取得制限数をセット
        if ($current_plan == SERVECE_PLAN['basic']['label']) {
            $get_post_num = 12;
        } else if ($current_plan == SERVECE_PLAN['premium']['label']) {
            $get_post_num = 54;
        } else if ($current_plan == SERVECE_PLAN['premium_s']['label']) {
            $get_post_num = 120;
        } else if (empty($current_plan)) {
            $get_post_num = 120;
        }

        //自分が所有するアカウント以外のInstagramビジネスアカウントが投稿している写真も取得したい場合は以下
        if (!empty($target_user)) {
            $fields =   'business_discovery.username(' . $target_user . ') {
                            id
                            , name
                            , username
                            , profile_picture_url
                            , followers_count
                            , follows_count
                            , media_count, ig_id
                            , media.limit(' . $get_post_num . ') {
                                caption
                                , media_url
                                , media_type
                                , children {
                                    media_url
                                    , media_type
                                }
                                , like_count
                                , comments_count
                                , timestamp
                                , id
                            }
                        }';
        }

        $fields = str_replace(array("\r\n", "\r", "\n", "\t", " "), '', $fields);
        //////////////////////
        /* 初期設定ここまで */
        //////////////////////

        //////////////////////
        /*     取得処理     */
        //////////////////////

        /*
      キャッシュしておいたファイルが指定時間以内に更新されていたらキャッシュしたファイルのデータを使用する
      指定時間以上経過していたら新たに Instagaram Graph API へリクエストする
      */

        // キャッシュ用のディレクトリが存在するか確認
        // なければ作成する
        $result = new Folder($cache_path, true, 0755);

        // キャッシュファイルの最終更新日時を取得
        $cache_lastmodified = @filemtime('s3://' . env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name);

        // 更新日時の比較
        if (!$cache_lastmodified) {
            // Graph API から JSON 形式でデータを取得
            $ig_json = @file_get_contents($graph_api . $ig_buisiness . '?fields=' . $fields . '&access_token=' . $access_token);
            // 取得したデータをキャッシュに保存する
            $stream = fopen('s3://' . env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name, 'w');
            fwrite($stream, $ig_json);
            fclose($stream);
        } else {
            if (time() - $cache_lastmodified > $cache_lifetime) {
                // キャッシュの最終更新日時がキャッシュ時間よりも古い場合は再取得する
                $ig_json = @file_get_contents($graph_api . $ig_buisiness . '?fields=' . $fields . '&access_token=' . $access_token);
                // 取得したデータをキャッシュに保存する
                $stream = fopen('s3://' . env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name, 'w');
                fwrite($stream, $ig_json);
                fclose($stream);
            } else {
                // キャッシュファイルが新しければキャッシュデータを使用する
                $ig_json = @file_get_contents('s3://' . env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name);
            }
        }

        // 取得したJSON形式データを配列に展開する
        if ($ig_json) {
            $ig_data = json_decode($ig_json);
            if (isset($ig_data->error)) {
                $ig_data = null;
            }
        }

        // 初期表示の設定確認
        if ($show_mode !== 'grid' && $show_mode !== 'list') {
            $show_mode = 'grid';
        }

        return $ig_data;
    }

}
