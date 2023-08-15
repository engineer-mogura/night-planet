<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Token\Model\Entity\TokenTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Owner Entity
 *
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $tel
 * @property string $email
 * @property string $password
 * @property int $gender
 * @property string $age
 * @property string|null $dir
 * @property string|null $remember_token
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\AccessMonth[] $access_months
 * @property \App\Model\Entity\AccessWeek[] $access_weeks
 * @property \App\Model\Entity\AccessYear[] $access_years
 * @property \App\Model\Entity\Adsense[] $adsenses
 * @property \App\Model\Entity\ServecePlan[] $servece_plans
 * @property \App\Model\Entity\Shop[] $shops
 */
class Owner extends Entity {
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
        'name' => true,
        'role' => true,
        'tel' => true,
        'email' => true,
        'password' => true,
        'gender' => true,
        'age' => true,
        'icon_image_file' => true,
        'remember_token' => true,
        'status' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
        'access_months' => true,
        'access_weeks' => true,
        'access_years' => true,
        'adsenses' => true,
        'servece_plans' => true,
        'shops' => true,
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
    protected function _getRegistryAlias() {
        return $this->_registryAlias;
    }
}
