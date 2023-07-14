<?php
    //変数展開用
    $_ = function ($s) {
        return $s;
    };
    $http = "http://";
    if (isset($_SERVER['HTTPS'])) {
        $http = "https://";
    }
    // TODO: ローカル環境の場合はMINIO は URLとバケット名をくっつけたやつでないと画像などが表示されない。
    // デフォルトはローカルで初期化
    $URL_S3_BUCKET = null;

    // 環境によるドメイン判定
    if(strpos($_SERVER['HTTP_HOST'],'local') !== false){
        // ローカル環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST').DS.env('AWS_BUCKET');
        define('AWS_S3_CONFIG', array(
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', ''),
                'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
            ],
            'region' => env('AWS_DEFAULT_REGION', ''),
            'version' => 'latest',
            'endpoint' => env('AWS_URL_DOCKER',''),
            'use_path_style_endpoint' => env('AWS_PATH_STYLE_ENDPOINT', false),
        ));
        define('PUBLIC_DOMAIN', $http . env('APP_URL'));
        define('ADMIN_DOMAIN', $http . env('APP_ADMIN_URL'));

        define('USER_NO_INDEX', true); //「userDefault.ctp」検索エンジンにインデックスしないか
        define('OWNER_NO_INDEX', true); // 「ownerDefault.ctp」検索エンジンにインデックスしないか
        define('SHOP_NO_INDEX', true); // 「shopDefault.ctp」検索エンジンにインデックスしないか
        define('CAST_NO_INDEX', true); // 「castDefault.ctp」検索エンジンにインデックスしないか
        define('SIMPLE_NO_INDEX', true); // 「simpleDefault.ctp」検索エンジンにインデックスしないか
        define('NO_FOLLOW', true); // ステージング環境用 ページ内のリンク先をフォローしないか
        // API関連プロパティ設定
        define('API', array(
            'GOOGLE_MAP_API_KEY'=>'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_API_KEY'), // ステージング環境用 GoogleマップのAPIキー
            //'GOOGLE_ANALYTICS_API'=>'https://www.googletagmanager.com/gtag/js?id='. env('GOOGLE_ANALYTICS_UA_ID'), // ステージング環境用 GoogleアナリティクスのAPIキー
            //'GOOGLE_ANALYTICS_UA_ID'=> env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのID
            'GOOGLE_ANALYTICS_VIEW_ID'=> env('GOOGLE_ANALYTICS_VIEW_ID'), // 本番環境用 Analytics Reporting API V4 view_id
            'GOOGLE_FORM_KEISAI_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_KEISAI_CONTACT', 'not defind!'), // Googleフォーム 掲載申し込みフォーム
            'GOOGLE_FORM_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_CONTACT', 'not defind!'), // Googleフォーム お問い合わせフォーム
            'INSTAGRAM_USER_NAME'=> env('INSTAGRAM_USER_NAME'), // INSTAGRAMビジネスアカウントネーム
            'INSTAGRAM_BUSINESS_ID'=> env('INSTAGRAM_BUSINESS_ID'), // INSTAGRAMビジネスアカウントID
            'INSTAGRAM_GRAPH_API_ACCESS_TOKEN'=> env('INSTAGRAM_GRAPH_API_ACCESS_TOKEN'), // #3INSTAGRAMアクセストークン
            'INSTAGRAM_GRAPH_API'=> 'https://graph.facebook.com/v4.0/', // インスタグラムのAPIパス
            'INSTAGRAM_MAX_POSTS'=> 9, // インスタグラムの最大投稿取得数
            'INSTAGRAM_SHOW_MODE'=> 'grid', // インスタグラム表示モード
            'INSTAGRAM_CACHE_TIME'=> 360, // インスタグラムキャッシュタイム
        ));
    } else if(strpos($_SERVER['HTTP_HOST'],'192.168.33.10') !== false){
        // スマホのローカル環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST').DS.env('AWS_BUCKET');
        define('AWS_S3_CONFIG', array(
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', ''),
                'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
            ],
            'region' => env('AWS_DEFAULT_REGION', ''),
            'version' => 'latest',
            'endpoint' => env('AWS_URL_DOCKER',''),
            'use_path_style_endpoint' => env('AWS_PATH_STYLE_ENDPOINT', false),
        ));
        define("PUBLIC_DOMAIN",'192.168.33.10');
        define("ADMIN_DOMAIN",'192.168.33.10');

        define("USER_NO_INDEX", true); //「userDefault.ctp」検索エンジンにインデックスしないか
        define("OWNER_NO_INDEX", true); // 「ownerDefault.ctp」検索エンジンにインデックスしないか
        define("SHOP_NO_INDEX", true); // 「shopDefault.ctp」検索エンジンにインデックスしないか
        define("CAST_NO_INDEX", true); // 「castDefault.ctp」検索エンジンにインデックスしないか
        define("SIMPLE_NO_INDEX", true); // 「simpleDefault.ctp」検索エンジンにインデックスしないか
        define("NO_FOLLOW", true); // ステージング環境用 ページ内のリンク先をフォローしないか
        // API関連プロパティ設定
        define('API', array(
            'GOOGLE_MAP_API_KEY'=>'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_API_KEY'), // ステージング環境用 GoogleマップのAPIキー
            //'GOOGLE_ANALYTICS_API'=>'https://www.googletagmanager.com/gtag/js?id='. env('GOOGLE_ANALYTICS_UA_ID'), // ステージング環境用 GoogleアナリティクスのAPIキー
            //'GOOGLE_ANALYTICS_UA_ID'=> env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのID
            'GOOGLE_ANALYTICS_VIEW_ID'=> env('GOOGLE_ANALYTICS_VIEW_ID'), // 本番環境用 Analytics Reporting API V4 view_id
            'GOOGLE_FORM_KEISAI_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_KEISAI_CONTACT', 'not defind!'), // Googleフォーム 掲載申し込みフォーム
            'GOOGLE_FORM_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_CONTACT', 'not defind!'), // Googleフォーム お問い合わせフォーム
            'INSTAGRAM_USER_NAME'=> env('INSTAGRAM_USER_NAME'), // INSTAGRAMビジネスアカウントネーム
            'INSTAGRAM_BUSINESS_ID'=> env('INSTAGRAM_BUSINESS_ID'), // INSTAGRAMビジネスアカウントID
            'INSTAGRAM_GRAPH_API_ACCESS_TOKEN'=> env('INSTAGRAM_GRAPH_API_ACCESS_TOKEN'), // #3INSTAGRAMアクセストークン
            'INSTAGRAM_GRAPH_API'=> 'https://graph.facebook.com/v4.0/', // インスタグラムのAPIパス
            'INSTAGRAM_MAX_POSTS'=> 9, // インスタグラムの最大投稿取得数
            'INSTAGRAM_SHOW_MODE'=> 'grid', // インスタグラム表示モード
            'INSTAGRAM_CACHE_TIME'=> 360, // インスタグラムキャッシュタイム
        ));
    } else if(strpos($_SERVER['HTTP_HOST'],'work') !== false){
        // ステージング環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST');
        define('AWS_S3_CONFIG', array(
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', ''),
                'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
            ],
            'region' => env('AWS_DEFAULT_REGION', ''),
            'version' => 'latest',
            // 'endpoint' => env('AWS_URL_DOCKER',''),
            // 'use_path_style_endpoint' => env('AWS_PATH_STYLE_ENDPOINT', false),
        ));
        define('PUBLIC_DOMAIN', $http . env('APP_URL'));
        define('ADMIN_DOMAIN', $http . env('APP_ADMIN_URL'));

        define("USER_NO_INDEX", true); //「userDefault.ctp」検索エンジンにインデックスしないか
        define("OWNER_NO_INDEX", true); // 「ownerDefault.ctp」検索エンジンにインデックスしないか
        define("SHOP_NO_INDEX", true); // 「shopDefault.ctp」検索エンジンにインデックスしないか
        define("CAST_NO_INDEX", true); // 「castDefault.ctp」検索エンジンにインデックスしないか
        define("SIMPLE_NO_INDEX", true); // 「simpleDefault.ctp」検索エンジンにインデックスしないか
        define("NO_FOLLOW", true); // ステージング環境用 ページ内のリンク先をフォローしないか
        // API関連プロパティ設定
        define('API', array(
            'GOOGLE_MAP_API_KEY'=>'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_API_KEY'), // ステージング環境用 GoogleマップのAPIキー
            //'GOOGLE_ANALYTICS_API'=>'https://www.googletagmanager.com/gtag/js?id='. env('GOOGLE_ANALYTICS_UA_ID'), // ステージング環境用 GoogleアナリティクスのAPIキー
            //'GOOGLE_ANALYTICS_UA_ID'=> env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのID
            'GOOGLE_ANALYTICS_VIEW_ID'=> env('GOOGLE_ANALYTICS_VIEW_ID'), // 本番環境用 Analytics Reporting API V4 view_id
            'GOOGLE_FORM_KEISAI_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_KEISAI_CONTACT', 'not defind!'), // Googleフォーム 掲載申し込みフォーム
            'GOOGLE_FORM_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_CONTACT', 'not defind!'), // Googleフォーム お問い合わせフォーム
            'INSTAGRAM_USER_NAME'=> env('INSTAGRAM_USER_NAME'), // INSTAGRAMビジネスアカウントネーム
            'INSTAGRAM_BUSINESS_ID'=> env('INSTAGRAM_BUSINESS_ID'), // INSTAGRAMビジネスアカウントID
            'INSTAGRAM_GRAPH_API_ACCESS_TOKEN'=> env('INSTAGRAM_GRAPH_API_ACCESS_TOKEN'), // #3INSTAGRAMアクセストークン
            'INSTAGRAM_GRAPH_API'=> 'https://graph.facebook.com/v4.0/', // インスタグラムのAPIパス
            'INSTAGRAM_MAX_POSTS'=> 9, // インスタグラムの最大投稿取得数
            'INSTAGRAM_SHOW_MODE'=> 'grid', // インスタグラム表示モード
            'INSTAGRAM_CACHE_TIME'=> 360, // インスタグラムキャッシュタイム
        ));
    } else {
        // 本番環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST');
        define('AWS_S3_CONFIG', array(
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', ''),
                'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
            ],
            'region' => env('AWS_DEFAULT_REGION', ''),
            'version' => 'latest',
            // 'endpoint' => env('AWS_URL_DOCKER',''),
            // 'use_path_style_endpoint' => env('AWS_PATH_STYLE_ENDPOINT', false),
        ));
        define('PUBLIC_DOMAIN', $http . env('APP_URL'));
        define('ADMIN_DOMAIN', $http . env('APP_ADMIN_URL'));

        define("USER_NO_INDEX", false); //「userDefault.ctp」検索エンジンにインデックスしないか
        define("OWNER_NO_INDEX", true); // 「ownerDefault.ctp」検索エンジンにインデックスしないか
        define("SHOP_NO_INDEX", true); // 「shopDefault.ctp」検索エンジンにインデックスしないか
        define("CAST_NO_INDEX", true); // 「castDefault.ctp」検索エンジンにインデックスしないか
        define("SIMPLE_NO_INDEX", true); // 「simpleDefault.ctp」検索エンジンにインデックスしないか
        define("NO_FOLLOW", false); // ステージング環境用 ページ内のリンク先をフォローしないか
        // API関連プロパティ設定
        define('API', array(
            'GOOGLE_MAP_API_KEY'=>'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_API_KEY'), // 本番環境用 GoogleマップのAPIキー
            'GOOGLE_ANALYTICS_API'=>'https://www.googletagmanager.com/gtag/js?id='. env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのAPIキー
            'GOOGLE_ANALYTICS_UA_ID'=> env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのID
            'GOOGLE_ANALYTICS_VIEW_ID'=> env('GOOGLE_ANALYTICS_VIEW_ID'), // 本番環境用 Analytics Reporting API V4 view_id
            'GOOGLE_FORM_KEISAI_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_KEISAI_CONTACT', 'not defind!'), // Googleフォーム 掲載申し込みフォーム
            'GOOGLE_FORM_CONTACT'=>'https://forms.gle/' . env('GOOGLE_FORM_CONTACT', 'not defind!'), // Googleフォーム お問い合わせフォーム
            'INSTAGRAM_USER_NAME'=> env('INSTAGRAM_USER_NAME'), // INSTAGRAMビジネスアカウントネーム
            'INSTAGRAM_BUSINESS_ID'=> env('INSTAGRAM_BUSINESS_ID'), // INSTAGRAMビジネスアカウントID
            'INSTAGRAM_GRAPH_API_ACCESS_TOKEN'=> env('INSTAGRAM_GRAPH_API_ACCESS_TOKEN'), // #3INSTAGRAMアクセストークン
            'INSTAGRAM_GRAPH_API'=> 'https://graph.facebook.com/v4.0/', // インスタグラムのAPIパス
            'INSTAGRAM_MAX_POSTS'=> 9, // インスタグラムの最大投稿取得数
            'INSTAGRAM_SHOW_MODE'=> 'grid', // インスタグラム表示モード
            'INSTAGRAM_CACHE_TIME'=> 360, // インスタグラムキャッシュタイム
        ));
    }

return [

    // バイトサイズ関連
    define('CAPACITY', array(
        'MAX_NUM_BYTES_DIR'=> 10485760 , // ディレクトリ制限バイト数10MB
        'MAX_NUM_BYTES_FILE'=> 2097152 , // ファイル制限バイト数2MB
    )),

    // プロパティ設定
    define('PROPERTY', array(
        'NEW_INFO_MAX'=>'4', // 新着情報関連の表示数
        'FILE_MAX'=>'9', // アップロードファイル数
        'UPDATE_INFO_DAY_MAX'=>'10', // アップロードファイル数
        'SHOW_GALLERY_MAX'=>'10', // スタッフのギャラリー最大表示数
        'TOP_SLIDER_GALLERY_MAX'=>'3', // トップスライダーのギャラリー最大表示数
        'SUB_SLIDER_GALLERY_MAX'=>'10', // サブスライダーのギャラリー最大表示数
        'RANKING_SHOW_MAX'=>'11', // ランキングの表示最大表示数
        'RANKING_SPAN_MAX'=>'15', // ランキングの日付範囲数
    )),

    // 店舗メニュー名
    define('SHOP_MENU_NAME', array(
        'COUPON'=>'coupon', // クーポン
        'WORK_SCHEDULE'=>'work_schedule', // 今日の出勤メンバー
        'EVENT'=>'event', // お知らせ
        'STAFF'=>'staff', // スタッフ
        'DIARY'=>'diary', // 日記
        'REVIEW'=>'レビュー', // 日記
        'SHOP_TOP_IMAGE'=>'shop_top_image', // 店舗トップ画像
        'SHOP_GALLERY'=>'shop_gallery', // 店内ギャラリー
        'SYSTEM'=>'shop_system', // 店舗情報
        'RECRUIT'=>'recruit', // 求人情報
        'PROFILE'=>'profile', // プロフィール
        'CAST_TOP_IMAGE'=>'cast_top_image', // スタッフトップ画像
        'CAST_GALLERY'=>'cast_gallery', // スタッフギャラリー
    )),

    // 店舗編集画面のタブ制御設定
    define('TAB_CONTROLE', array(
        'index',        // 店舗ダッシュボード 画面
        'notice',       // 店舗お知らせ 画面
        'option',       // 設定 画面
        'workSchedule', // 出勤管理 画面
    )),

    // パス設定 path.config
    define('PATH_ROOT', array(
        'NO_IMAGE01'=> $URL_S3_BUCKET . '/others/no-img16.png',
        'NO_IMAGE02'=> $URL_S3_BUCKET . '/others/noimage.jpg',
        'NO_IMAGE03'=> $URL_S3_BUCKET . '/others/no-img150_150/no-img7.png',
        'NO_IMAGE04'=> $URL_S3_BUCKET . '/others/no-img150_150/no-img8.png',
        'NO_IMAGE05'=> $URL_S3_BUCKET . '/others/no-img150_150/no-img9.png',
        'NO_IMAGE06'=> $URL_S3_BUCKET . '/others/unknow.png',
        'NO_RANKING'=> $URL_S3_BUCKET . '/others/no-ranking.jpg',
        'NIGHT_PLANET_IMAGE'=> $URL_S3_BUCKET . '/others/night_planet_top_icon.png',
        'NIGHT_PLANET_CHARA'=> 'https://drive.google.com/uc?id=1VaqWsqOBUm7dnji0iHbCkSAgIlAp7dn6',
        'NIGHT_PLANET_CACHE'=> '/img/tmp/cache/',
        'CAST_TOP_IMAGE'=> $URL_S3_BUCKET . '/others/cast/top-image.jpg',
        'SHOP_TOP_IMAGE'=> $URL_S3_BUCKET . '/others/shop/top-image.png',
        'CREDIT'=> $URL_S3_BUCKET . '/others/credit/',
        'COUPON'=> $URL_S3_BUCKET . '/others/coupon/coupon1.jpg',
        'USER'=> 'user',
        'CAST'=> 'cast',
        'DEVELOPER'=> 'developer',
        'ADSENSE'=> 'adsense',
        'NOTICE'=> 'notice',
        'DIARY'=> 'diary',
        'NEWS'=> 'news',
        'REVIEW'=> 'review',
        'GALLERY'=> 'gallery',
        'SCHEDULE'=> 'schedule',
        'TMP'=> 'tmp',
        'TOP_IMAGE'=> 'top_image',
        'IMAGE'=> 'image',
        'ICON'=> 'icon',
        'CACHE'=> 'cache',
        'BACKUP'=> 'backup',
        'URL_S3_BUCKET'=> $URL_S3_BUCKET, // minio/s3 URLとバケット名をくっつけたやつ
        'OTHERS'=> 'others',
        'USERS'=> 'users',
        'SHOPS'=> 'shops',
        'OWNERS'=> 'owners',
        'SHOP'=> 'shop',
    )),

    // SNSパス設定 path.config
    define('SHARER', array(
        'TWITTER'=> env('SHARER_TWITTER'),
        'FACEBOOK'=> env('SHARER_FACEBOOK'),
        'LINE'=> env('SHARER_LINE'),
        'FACEBOOK_APP_ID'=> env('SHARER_FACEBOOK_APP_ID'),
    )),
    // SNSリンク設定 path.config
    define('SNS', array(
        'INSTAGRAM'=> env('INSTAGRAM'),
        'FACEBOOK'=> env('FACEBOOK'),
        'TWITTER'=> env('TWITTER'),

    )),

    // ラベル定数 developer.label menu
    define('DEVELOPER_LM', array(
        '001'=>'開発者リスト',
        '002'=>'ユーザーリスト',
        '003'=>'オーナーリスト',
    )),

    // ラベル定数 label title
    define('LT', array(
        '000'=>'NightPlanet ナイプラ',
        '001'=>'<span class="logo-head-color">N</span>ight<span class="logo-head-color"> P</span>lanet<span style="font-size: x-small"> ナイプラ</span>',
        '002'=>'Copyright 2018',
        '003'=>'<span class="logo-head-color">N</span>ight<span class="logo-head-color"> P</span>lanet<span style="font-size: x-small"> ナイプラ</span> All Rights Reserved.',
        '004'=>'管理画面',
        '005'=>'<span class="area-logo-tail">☽ナイト検索☽</span>',
        '006'=>'オーナーログイン画面',
        '007'=>'スタッフログイン画面',
    )),

    // ラベル定数 owner.label menu
    define('USER_LM', array(
        '001'=>'新着情報',
        '002'=>'特集',
        '003'=>'ランキング',
        '004'=>'トップページ',
        '005'=>'Instagram',
        '006'=>'FaceBook',
        '007'=>'Twitter',
        '008'=>'店舗の掲載をご希望の方',
        '009'=>'店舗ログイン',
    )),

    // ラベル定数 owner.label menu
    define('OWNER_LM', array(
        '001'=>'ダッシュボード',
        '002'=>'オーナー情報',
        '003'=>'契約内容・お支払い',
    )),

    // ラベル定数 shop.label menu
    define('SHOP_LM', array(
        '001'=>'トップ画像',
        '002'=>'キャッチコピー',
        '003'=>'クーポン',
        '004'=>'スタッフ',
        '005'=>'店舗情報',
        '006'=>'店舗ギャラリー',
        // '007'=>'マップ',
        '008'=>'求人情報',
        '009'=>'店舗お知らせ',
        '010'=>'SNS',
        '011'=>'出勤管理',
        '012'=>'ダッシュボード',
        '013'=>'設定',
    )),

    // ラベル定数 cast.label menu
    define('CAST_LM', array(
        '001'=>'ダッシュボード',
        '002'=>'プロフィール',
        '003'=>'トップ画像',
        '004'=>'日記',
        '005'=>'ギャラリー',
        '006'=>'SNS',
        '007'=>'スタッフのトップへ行く',
    )),

    // ラベルボタン定数 common.label button
    define('COMMON_LB', array(
        '001'=>'表示',
        '002'=>'編集',
        '003'=>'追加',
        '004'=>'削除',
        '005'=>'変更',
        '006'=>'登録',
        '050'=>'でログイン中',
        '051'=>'ログイン',
        '052'=>'もっと見る',
        '053'=>'店舗詳細',
    )),

    // ラベル定数 common.label menu
    define('COMMON_LM', array(
        '001'=>'よくある質問',
        '002'=>'お問い合わせ',
        '003'=>'プライバシーポリシー',
        '004'=>'トップに戻る',
        '005'=>'ご利用規約',
        '006'=>'ログイン',
        '007'=>'ログアウト',
    )),

    define('CATCHCOPY', '【NightPlanet<span style="font-size: small"> ナイプラ</span>】では、県内特化型ポータルサイトとして、沖縄全域のナイト情報を提供しております。高機能な検索システムを採用しておりますので、お客様にピッタリな情報がすぐに見つかります。店舗ごとに多彩なクーポン券もご用意しておりますので、お店に行く前にクーポン券をチェックしてみるのもいいでしょう。'),

    // 領域リスト
    define('REGION', array(
            'okinawa'=> [
                'label' => "沖縄",
                'path' => "okinawa",
                'color' => "lime darken-1",
            ],
            'south'=> [
                'label' => "南部",
                'path' => "south",
                'color' => "deep-orange darken-2",
            ],
            'center'=> [
                'label' => "中部",
                'path' => "center",
                'color' => "light-green darken-2",
            ],
            'north'=> [
                'label' => "北部",
                'path' => "north",
                'color' => "cyan darken-1",
            ],
            'miyakojima'=> [
                'label' => "宮古島",
                'path' => "miyakojima",
                'color' => "lime darken-1",
            ],
            'ishigakijima'=> [
                'label' => "石垣島",
                'path' => "ishigakijima",
                'color' => "lime darken-1",
            ],
    )),
    // 所属エリアリスト
    define('AREA', array(
        'okinawa'=> [
            'label' => "沖縄",
            'path' => "okinawa",
            'region' => "okinawa"
        ],
        'naha'=> [
            'label' => "那覇",
            'path' => "naha",
            'region' => "south"
        ],
        'nanjo'=> [
            'label' => "南城",
            'path' => "nanjo",
            'region' => "south"
        ],
        'tomigusuku'=> [
            'label' => "豊見城",
            'path' => "tomigusuku",
            'region' => "south"
        ],
        'itoman'=> [
            'label' => "糸満",
            'path' => "itoman",
            'region' => "south"
        ],
        'haebaru'=> [
            'label' => "南風原",
            'path' => "haebaru",
            'region' => "south"
        ],
        'yonabaru'=> [
            'label' => "与那原",
            'path' => "yonabaru",
            'region' => "south"
        ],
        'urasoe'=> [
            'label' => "浦添",
            'path' => "urasoe",
            'region' => "center"
        ],
        'ginowan'=> [
            'label' => "宜野湾",
            'path' => "ginowan",
            'region' => "center"
        ],
        'chatan'=> [
            'label' => "北谷",
            'path' => "chatan",
            'region' => "center"
        ],
        'nishihara'=> [
            'label' => "西原",
            'path' => "nishihara",
            'region' => "center"
        ],
        'okinawashi'=> [
            'label' => "沖縄市",
            'path' => "okinawashi",
            'region' => "center"
        ],
        'uruma'=> [
            'label' => "うるま",
            'path' => "uruma",
            'region' => "center"
        ],
        'nago'=> [
            'label' => "名護",
            'path' => "nago",
            'region' => "north"
        ],
        'miyakojima'=> [
            'label' => "宮古島",
            'path' => "miyakojima",
            'region' => "miyakojima"
        ],
        'ishigakijima'=> [
            'label' => "石垣島",
            'path' => "ishigakijima",
            'region' => "ishigakijima"
        ],
    )),
    // 業種リスト
    define('GENRE', array(
        'cabacula'=> [
            'label' => "キャバクラ",
            'path' => "cabacula",
            'image' => $URL_S3_BUCKET . "/others/genre/cabacura.jpeg"
        ],
        'snack'=> [
            'label' => "スナック",
            'path' => "snack",
            'image' => $URL_S3_BUCKET . "/others/genre/snack.jpg"
        ],
        'girlsbar'=> [
            'label' => "ガールズバー",
            'path' => "girlsbar",
            'image' => $URL_S3_BUCKET . "/others/genre/girsbar.jpeg"
        ],
        'club'=> [
            'label' => "クラブ",
            'path' => "club",
            'image' => $URL_S3_BUCKET . "/others/genre/rounge.jpg"
        ],
        'lounge'=> [
            'label' => "ラウンジ",
            'path' => "lounge",
            'image' => $URL_S3_BUCKET . "/others/genre/rounge.jpg"
        ],
        'pub'=> [
            'label' => "パブ",
            'path' => "pub",
            'image' => $URL_S3_BUCKET . "/others/genre/cabacura.jpeg"
        ],
        'bar'=> [
            'label' => "バー",
            'path' => "bar",
            'image' => $URL_S3_BUCKET . "/others/genre/bar.jpg"
        ],
    )),
    // 星座リスト
    define('CONSTELLATION', array(
        'constellation1'=> [
            'label' => "おひつじ座",
            'path' => "constellation1"
        ],
        'constellation2'=> [
            'label' => "おうし座",
            'path' => "constellation2"
        ],
        'constellation3'=> [
            'label' => "ふたご座",
            'path' => "constellation3"
        ],
        'constellation4'=> [
            'label' => "かに座",
            'path' => "constellation4"
        ],
        'constellation5'=> [
            'label' => "しし座",
            'path' => "constellation5"
        ],
        'constellation6'=> [
            'label' => "おとめ座",
            'path' => "constellation6"
        ],
        'constellation7'=> [
            'label' => "てんびん座",
            'path' => "constellation7"
        ],
        'constellation8'=> [
            'label' => "さそり座",
            'path' => "constellation8"
        ],
        'constellation9'=> [
            'label' => "いて座",
            'path' => "constellation9"
        ],
        'constellation10'=> [
            'label' => "やぎ座",
            'path' => "constellation10"
        ],
        'constellation11'=> [
            'label' => "みずがめ座",
            'path' => "constellation11"
        ],
        'constellation12'=> [
            'label' => "うお座",
            'path' => "constellation12"
        ],

    )),
    // 血液型リスト
    define('BLOOD_TYPE', array(
        'blood_type1'=> [
            'label' => "A型",
            'path' => "blood_type1"
        ],
        'blood_type2'=> [
            'label' => "B型",
            'path' => "blood_type2"
        ],
        'blood_type3'=> [
            'label' => "O型",
            'path' => "blood_type3"
        ],
        'blood_type4'=> [
            'label' => "AB型",
            'path' => "blood_type4"
        ],

    )),
    // 所属エリアリスト
    define('USER', array(
        'index'=> [
            'label' => "マイページ",
            'path' => "mypage",
        ],
        'voice'=> [
            'label' => "口コミ",
            'path' => "voice",
        ],
    )),
    // 共通メッセージ common.message
    define('COMMON_M', array(
        'LOGINED'=>'ログインしました。',
        'LOGGED_OUT'=>'ログアウトしました。',
    )),
    // 確認メッセージ common.message
    define('CONFIRM_M', array(
        'TEL_ME'=>'【_shopname_】に電話を掛けますか？\n電話をする際は【ナイプラ】を見た！で話がスムーズになります。',
    )),

    // 結果メッセージ info.result.message
    define('RESULT_M', array(
        'SIGNUP_SUCCESS'=>'登録しました。',
        'UPDATE_SUCCESS'=>'編集しました。',
        'DELETE_SUCCESS'=>'削除しました。',
        'DISPLAY_SUCCESS'=>'を表示にしました',
        'HIDDEN_SUCCESS'=>'を非表示にしました',
        'AUTH_SUCCESS'=>'認証完了しました。ログインしてください。',
        'PASS_RESET_SUCCESS'=>'パスワード変更完了しました。ログインしてください。',
        'CHANGE_PLAN_SUCCESS'=>'プランの変更が完了しました。ご登録のメールアドレスにお支払いの案内がありますのでご確認ください。',
        'DUPLICATE'=>'同じ画像はアップできませんでした。',
        'SIGNUP_FAILED'=>'登録に失敗しました。もう一度登録しなおしてください。',
        'UPDATE_FAILED'=>'編集に失敗しました。もう一度編集しなおしてください。',
        'DELETE_FAILED'=>'削除に失敗しました。もう一度削除しなおしてください。',
        'AUTH_FAILED'=>'認証に失敗しました。もう一度登録しなおしてください。',
        'PASS_RESET_FAILED'=>'一定時間が過ぎました。もう一度やり直してください。',
        'CHANGE_PLAN_FAILED'=>'プランの変更に失敗しました。お手数ですがもう一度試して頂いてみてもダメな場合お問い合わせからご連絡の方お願い致します。',
        'REGISTERED_FAILED'=>'すでに登録されてます。ログインしてください。',
        'FRAUD_INPUT_FAILED'=>'メールアドレスまたはパスワードが不正です。',
        'CHANGE_FAILED'=>'切り替えに失敗しました。もう一度お試しください。',
        'SHOP_ADD_FAILED'=>'店舗を追加するには、【_service_plan_】に変更が必要です。',
        'INSTA_ADD_FAILED'=>'Instagramを追加するには、フリープラン以外の変更が必要です。',
        'INSTA_ADD_CAST_FAILED'=>'Instagramを追加するには、【_service_plan_】に変更が必要です。',
    )),

    // メール設定 ※ここを変更した場合は、Gmailのフィルタ条件も変更してください。
    define('MAIL', array(
        'CAST_AUTH_CONFIRMATION'=>'入力したアドレスにメールを送りました。URLをクリックし、認証を完了してください。１時間以内に完了してください。',
        'OWNER_AUTH_CONFIRMATION'=>'入力したアドレスにメールを送りました。URLをクリックし、認証を完了してください。１時間以内に完了してください。',
        'INFO_MAIL'=>env('INFO_MAIL'),
        'SUBSCRIPTION_MAIL'=>env('SUBSCRIPTION_MAIL'),
        'CONTACT_MAIL'=>env('CONTACT_MAIL'),
        'SUPPORT_MAIL'=>env('SUPPORT_MAIL'),
        'FROM_NAME'=>'NightPlanet事務局',
        'FROM_NAME_PASS_RESET'=>'【NightPlanet ﾅｲﾌﾟﾗ】パスワード再設定',
        'FROM_NAME_CHANGE_PLAN'=>'【NightPlanet ﾅｲﾌﾟﾗ】プラン変更完了とお支払いのご案内',
        'EXPIRED_SERVICE_PLAN'=>'【NightPlanet ﾅｲﾌﾟﾗ】サービスプランの有効期限切れのお知らせ',
    )),

    // SEO タイトル
    define('TITLE', array(
        'TOP_TITLE'=>'沖縄のキャバ|クラブ|ガールズバー|スナック|バーの検索サイト。『_service_name_』',
        'AREA_TITLE'=>'_area_のキャバクラ|クラブ|ガールズバー|スナック|バーを探すなら、『_service_name_』',
        'GENRE_TITLE'=>'_area_の_genre_を探すなら、『_service_name_』',
        'SEARCH_TITLE'=>'沖縄のキャバ|クラブ|ガールズバー|スナック|バーの検索サイト。『_service_name_』',
        'SHOP_TITLE'=>'_area_の_genre_ _shop_『_service_name_』',
        'NOTICE_TITLE'=>'_area_の_genre_ _shop_のお知らせ一覧『_service_name_』',
        'CAST_TITLE'=>'_area_の_genre_ _shop_|_cast_『_service_name_』',
        'DIARY_TITLE'=>'_area_の_genre_ _shop_|_cast_の日記ページ。『_service_name_』',
        'GALLERY_TITLE'=>'_area_の_genre_ _shop_|_cast_のギャラリーページ。『_service_name_』',
    )),

    // SEO メタ関連
    define('META', array(
        'TOP_DESCRIPTION'=>'沖縄県内のキャバクラ・クラブ・ガールズバー・スナック・バーの検索サイト『_service_name_』は男女問わず気軽にお店の検索ができます。普段見つからないような穴場スポットも見つかるかも。',
        'AREA_DESCRIPTION'=>'_area_のキャバクラ・クラブ・ガールズバー・スナック・バーをお探しなら『_service_name_』で！店舗毎にお得なクーポン情報もあります！まずは検索から！',
        'GENRE_DESCRIPTION'=>'_area_の_genre_をお探しなら『_service_name_』で！店舗毎にお得なクーポン情報もあります！まずは検索から！',
        'SEARCH_DESCRIPTION'=>'沖縄県内のキャバクラ・クラブ・ガールズバー・スナック・バーの検索サイト『_service_name_』は男女問わず気軽にお店の検索ができます。普段見つからないような穴場スポットも見つかるかも。',
        'SHOP_DESCRIPTION'=>'_catch_copy_ お店探しは『_service_name_』で！',
        'NOTICE_DESCRIPTION'=>'_shop_からのお知らせページです！お得な情報も発信しますのでお見逃しなく！お店探しは『_service_name_』で！',
        'CAST_DESCRIPTION'=>'_cast_のトップページです！様々なスタッフが在籍しています！新人スタッフも随時紹介していきます！お店探しは『_service_name_』で！',
        'DIARY_DESCRIPTION'=>'_cast_の日記ページです！日々の出来事などを日記に綴っていきますのでお見逃しなく！お店探しは『_service_name_』で！',
        'GALLERY_DESCRIPTION'=>'_cast_のギャラリーページです！毎日更新していきますのでお見逃しなく！お店探しは『_service_name_』で！',
    )),

    // サービスプラン
    define('SERVECE_PLAN', array(
        'free'=> [
            'name' => "フリープラン",
            'label' => "free",
            'charge' => "0"
        ],
        'basic'=> [
            'name' => "ベーシックプラン",
            'label' => "basic",
            'charge' => "5000"
        ],
        'premium'=> [
            'name' => "プレミアムプラン",
            'label' => "premium",
            'charge' => "10000"
        ],
        'premium_s'=> [
            'name' => "プレミアムSプラン",
            'label' => "premium_s",
            'charge' => "20000"
        ],
    )),

];
