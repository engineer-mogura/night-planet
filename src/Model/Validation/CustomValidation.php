<?php
namespace App\Model\Validation;

use Cake\Validation\Validation;

/**
 * カスタムバリデーションクラス
 */
class CustomValidation extends Validation
{
    /**
     * 電話番号フォーマットのチェック
     * TODO: libphonenumber-for-phpというプラグインを使うか検討。
     *       今の所はこの正規表現で対応する。
     *       参考：https://qiita.com/the_red/items/fcedd5033530b7ff7ee7
     * @param string $value
     * @param bool $context
     * @return bool
     */
    public function tel_check($value, $context)
    {
        //boolで返さないとエラー
        return (bool) preg_match('/^[0-9]{2,5}?[0-9]{2,5}?[0-9]{2,5}$/', $value);
    }

    /**
     * 片方のみ入力時エラーのチェック
     *
     * @return void
     */
    // public function from_to_day_check() {
    //     return !($this->data[$this->name]['from_day'] xor $this->data[$this->name]['to_day']);
    // }
}
