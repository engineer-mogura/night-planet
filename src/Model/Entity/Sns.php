<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sns Entity
 *
 * @property int $id
 * @property int|null $shop_id
 * @property int|null $cast_id
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $line
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Cast $cast
 */
class Sns extends Entity
{
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
        'facebook' => true,
        'twitter' => true,
        'instagram' => true,
        'line' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'cast' => true,
    ];
}
