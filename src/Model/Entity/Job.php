<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property string|null $industry
 * @property string|null $job_type
 * @property \Cake\I18n\FrozenTime|null $work_from_time
 * @property \Cake\I18n\FrozenTime|null $work_to_time
 * @property string|null $work_time_hosoku
 * @property string|null $from_age
 * @property string|null $to_age
 * @property string|null $qualification_hosoku
 * @property string|null $holiday
 * @property string|null $holiday_hosoku
 * @property string|null $treatment
 * @property string|null $pr
 * @property string|null $tel1
 * @property string|null $tel2
 * @property string|null $email
 * @property string|null $lineid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Shop $shop
 */
class Job extends Entity
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
        'industry' => true,
        'job_type' => true,
        'work_from_time' => true,
        'work_to_time' => true,
        'work_time_hosoku' => true,
        'from_age' => true,
        'to_age' => true,
        'qualification_hosoku' => true,
        'holiday' => true,
        'holiday_hosoku' => true,
        'treatment' => true,
        'pr' => true,
        'tel1' => true,
        'tel2' => true,
        'email' => true,
        'lineid' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
    ];
}
