<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CastSchedule Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property int $cast_id
 * @property int|null $event_type_id
 * @property string|null $title
 * @property string|null $details
 * @property \Cake\I18n\FrozenTime|null $start
 * @property \Cake\I18n\FrozenTime|null $end
 * @property string|null $time_start
 * @property string|null $time_end
 * @property string|null $all_day
 * @property string|null $status
 * @property int|null $active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Cast $cast
 * @property \App\Model\Entity\EventType $event_type
 */
class CastSchedule extends Entity {
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
        'event_type_id' => true,
        'title' => true,
        'details' => true,
        'start' => true,
        'end' => true,
        'time_start' => true,
        'time_end' => true,
        'all_day' => true,
        'status' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'cast' => true,
        'event_type' => true,
    ];
}
