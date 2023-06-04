<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterCode Entity
 *
 * @property int $id
 * @property string $code
 * @property string $code_name
 * @property string $code_group
 * @property int $sort
 * @property string|null $delete_flag
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class MasterCode extends Entity
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
        'id' => true,
        'code' => true,
        'code_name' => true,
        'code_group' => true,
        'sort' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
    ];
}
