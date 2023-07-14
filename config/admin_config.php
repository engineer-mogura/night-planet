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
    if(strpos($_SERVER['HTTP_HOST'],'local') !== false) {
        // ローカル環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST').DS.env('AWS_BUCKET');
    } else if(strpos($_SERVER['HTTP_HOST'],'work') !== false){
        // 本番環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST');
    } else {
        // 本番環境の場合
        $URL_S3_BUCKET = env('AWS_URL_HOST');
    }
return [
    define('PUBLIC_DOMAIN', $http . env('APP_URL')),
    define('ADMIN_DOMAIN', $http . env('APP_ADMIN_URL')),

    define("USER_NO_INDEX", false), //「userDefault.ctp」検索エンジンにインデックスしないか
    define("OWNER_NO_INDEX", true), // 「ownerDefault.ctp」検索エンジンにインデックスしないか
    define("SHOP_NO_INDEX", true), // 「shopDefault.ctp」検索エンジンにインデックスしないか
    define("CAST_NO_INDEX", true), // 「castDefault.ctp」検索エンジンにインデックスしないか
    define("SIMPLE_NO_INDEX", true), // 「simpleDefault.ctp」検索エンジンにインデックスしないか
    define("NO_FOLLOW", false), // ステージング環境用 ページ内のリンク先をフォローしないか
    // API関連プロパティ設定
    define('API', array(
        'GOOGLE_MAP_API_KEY'=>'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_API_KEY'), // 本番環境用 GoogleマップのAPIキー
        //'GOOGLE_ANALYTICS_API'=>'https://www.googletagmanager.com/gtag/js?id='. env('GOOGLE_ANALYTICS_UA_ID'), // 本番環境用 GoogleアナリティクスのAPIキー
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
    )),

    // ヘルプ関連
    define('HELP_SHOP', array(
            'TOP_IMAGE_01'=> $URL_S3_BUCKET . '/others/help/shop/top-image_01.png' ,
            'CATCH_01'=> $URL_S3_BUCKET . '/others/help/shop/catch_01.png' ,
            'CATCH_02'=> $URL_S3_BUCKET . '/others/help/shop/catch_02.png' ,
            'COUPON_01'=> $URL_S3_BUCKET . '/others/help/shop/coupon_01.png' ,
            'SNS_01'=> $URL_S3_BUCKET . '/others/help/shop/sns_01.png' ,
            'SNS_02'=> $URL_S3_BUCKET . '/others/help/shop/sns_02.png' ,
            'SNS_03'=> $URL_S3_BUCKET . '/others/help/shop/sns_03.png'
        )
    ),
];
