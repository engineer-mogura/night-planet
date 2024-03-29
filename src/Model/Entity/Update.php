<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Update Entity
 *
 * @property int $id
 * @property int|null $shop_id
 * @property int|null $cast_id
 * @property string|null $type
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Cast $cast
 */
class Update extends Entity {
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
        'cast_id' => true,
        'type' => true,
        'content' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'cast' => true,
    ];
}
