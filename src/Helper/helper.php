<?php
namespace App\Helper;

class helper
{
  public static $charArys = array('UTF-8', 'eucJP-win', 'SJIS-win', 'ASCII', 'EUC-JP', 'SJIS', 'JIS');

  public static function encode (string $str) : string {
    $beforStr = $str;
    $convertStr = "";
    $charCode = mb_detect_encoding($beforStr, self::$charArys);
    if ($charCode !== 'UTF-8') {
      $convertStr = mb_convert_encoding($beforStr, 'UTF-8', $charCode);
    } else {
      return $beforStr;
    }
    return $convertStr;
  }

}