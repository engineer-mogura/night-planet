<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShopLike Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\User $user
 */
class ShopLike extends Entity {
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
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'user' => true,
    ];

    /**
     * ƒe[ƒuƒ‹–¼‚ğ•Ô‹p‚·‚é
     *
     *
     * @return void
     */
    protected function _getRegistryAlias() {
        return $this->_registryAlias;
    }
}
