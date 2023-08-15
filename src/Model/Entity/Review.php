<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Review Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property int $cost
 * @property int $atmosphere
 * @property int $customer
 * @property int $staff
 * @property int $cleanliness
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\User $user
 */
class Review extends Entity {
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
        'cost' => true,
        'atmosphere' => true,
        'customer' => true,
        'staff' => true,
        'cleanliness' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'user' => true,
    ];
    /**
     * フルアドレスを返却する
     *
     *
     * @return void
     */
    protected function _getReviewAverage() {
        $average = ($this->_properties['cost'] + $this->_properties['atmosphere']
            + $this->_properties['customer'] + $this->_properties['staff']
            + $this->_properties['cleanliness']) / 5;

        return $average;
    }

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
