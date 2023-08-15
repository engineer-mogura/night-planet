<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * News Entity
 *
 * @property int $id
 * @property int $developer_id
 * @property string $title
 * @property string $content
 * @property string|null $dir
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Developer $developer
 */
class News extends Entity {
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
        'developer_id' => true,
        'title' => true,
        'content' => true,
        'dir' => true,
        'created' => true,
        'modified' => true,
        'developer' => true,
    ];

    /**
     * ƒe[ƒuƒ‹–¼‚ğ•Ô‹p‚·‚é
     * @return void
     */
    protected function _getRegistryAlias() {
        return $this->_registryAlias;
    }
}
