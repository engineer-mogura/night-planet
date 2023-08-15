<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ServecePlan Entity
 *
 * @property int $id
 * @property int $owner_id
 * @property string $current_plan
 * @property string $previous_plan
 * @property int $course
 * @property \Cake\I18n\FrozenDate $from_start
 * @property \Cake\I18n\FrozenDate $to_end
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Owner $owner
 */
class ServecePlan extends Entity {
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
        'current_plan' => true,
        'previous_plan' => true,
        'course' => true,
        'from_start' => true,
        'to_end' => true,
        'created' => true,
        'modified' => true,
        'owner' => true,
    ];
}
