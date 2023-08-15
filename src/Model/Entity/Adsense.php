<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Adsense Entity
 *
 * @property int $id
 * @property int $owner_id
 * @property int $shop_id
 * @property string|null $type
 * @property string|null $area
 * @property string|null $genre
 * @property string|null $name
 * @property string|null $catch
 * @property \Cake\I18n\FrozenDate $valid_start
 * @property \Cake\I18n\FrozenDate $valid_end
 * @property int $top_show_flg
 * @property int $area_show_flg
 * @property int|null $top_order
 * @property int|null $area_order
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Owner $owner
 * @property \App\Model\Entity\Shop $shop
 */
class Adsense extends Entity {
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
        'owner_id' => true,
        'shop_id' => true,
        'type' => true,
        'area' => true,
        'genre' => true,
        'name' => true,
        'catch' => true,
        'valid_start' => true,
        'valid_end' => true,
        'top_show_flg' => true,
        'area_show_flg' => true,
        'top_order' => true,
        'area_order' => true,
        'created' => true,
        'modified' => true,
        'owner' => true,
        'shop' => true,
    ];
}
