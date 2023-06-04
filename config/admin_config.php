<?php
    //変数展開用
    $_ = function ($s) {
        return $s;
    };

return [

    // バイトサイズ関連
    define('HELP_SHOP', array(
        'TOP_IMAGE_01'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/top-image_01.png' ,
        'CATCH_01'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/catch_01.png' ,
        'CATCH_02'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/catch_02.png' ,
        'COUPON_01'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/coupon_01.png' ,
        'SNS_01'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/sns_01.png' ,
        'SNS_02'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/sns_02.png' ,
        'SNS_03'=> env('AWS_URL_HOST').DS.env('AWS_BUCKET').'/others/help/shop/sns_03.png' ,
    )),
];
