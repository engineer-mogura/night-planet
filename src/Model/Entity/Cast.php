<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Token\Model\Entity\TokenTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Cast Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property string $role
 * @property string $name
 * @property string $nickname
 * @property string $email
 * @property string|null $password
 * @property \Cake\I18n\FrozenTime|null $birthday
 * @property string|null $three_size
 * @property string|null $blood_type
 * @property string|null $constellation
 * @property string|null $age
 * @property string|null $message
 * @property string|null $holiday
 * @property string|null $dir
 * @property string|null $remember_token
 * @property int $status
 * @property int|null $delete_flag
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Diary[] $diarys
 * @property \App\Model\Entity\CastSchedule[] $cast_schedules
 * @property \App\Model\Entity\Diary[] $diarys
 * @property \App\Model\Entity\Sns[] $snss
 * @property \App\Model\Entity\Update[] $updates
 */
class Cast extends Entity
{
    use TokenTrait;
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'shop_id' => true,
        'role' => true,
        'name' => true,
        'nickname' => true,
        'email' => true,
        'password' => true,
        'birthday' => true,
        'three_size' => true,
        'blood_type' => true,
        'constellation' => true,
        'age' => true,
        'message' => true,
        'holiday' => true,
        'dir' => true,
        'remember_token' => true,
        'status' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'cast_likes' => true,
        'cast_schedules' => true,
        'diarys' => true,
        'snss' => true,
        'updates' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        //'remember_token',  // 自動ログイン用トークン TODO: リリース前にコメントインする
        ];

    /**
     * テーブル名を返却する
     *
     *
     * @return void
     */
    protected function _getRegistryAlias()
    {
        return $this->_registryAlias;
    }

}
