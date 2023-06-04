<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Token\Model\Entity\TokenTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Tmp Entity
 *
 * @property int $id
 * @property string $name
 * @property int $shop_id
 * @property string $role
 * @property string $nickname
 * @property string $tel
 * @property string $email
 * @property string|null $password
 * @property \Cake\I18n\FrozenTime|null $birthday
 * @property string|null $three_size
 * @property int $gender
 * @property string $age
 * @property string|null $blood_type
 * @property string|null $constellation
 * @property string|null $message
 * @property string|null $holiday
 * @property string|null $dir
 * @property string|null $file_name
 * @property string|null $remember_token
 * @property int $status
 * @property int|null $delete_flag
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 */
class Tmp extends Entity
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
        'shop_id' => true,
        'role' => true,
        'nickname' => true,
        'tel' => true,
        'email' => true,
        'password' => true,
        'birthday' => true,
        'three_size' => true,
        'gender' => true,
        'age' => true,
        'blood_type' => true,
        'constellation' => true,
        'message' => true,
        'holiday' => true,
        'dir' => true,
        'file_name' => true,
        'remember_token' => true,
        'status' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
        'shop' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    /**
     * ƒe[ƒuƒ‹–¼‚ğ•Ô‹p‚·‚é
     *
     *
     * @return void
     */
    protected function _getRegistryAlias()
    {
        return $this->_registryAlias;
    }
}
