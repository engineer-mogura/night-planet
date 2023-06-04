<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Token\Model\Entity\TokenTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $email
 * @property string $password
 * @property int $gender
 * @property string|null $file_name
 * @property string|null $remember_token
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\CastLike[] $cast_likes
 * @property \App\Model\Entity\DiaryLike[] $diary_likes
 * @property \App\Model\Entity\Review[] $reviews
 * @property \App\Model\Entity\ShopInfoLike[] $shop_info_likes
 * @property \App\Model\Entity\ShopLike[] $shop_likes
 */
class User extends Entity
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
        'name' => true,
        'role' => true,
        'email' => true,
        'password' => true,
        'gender' => true,
        'file_name' => true,
        'remember_token' => true,
        'status' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
        'cast_likes' => true,
        'diary_likes' => true,
        'reviews' => true,
        'shop_info_likes' => true,
        'shop_likes' => true,
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
