<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Diary Entity
 *
 * @property int $id
 * @property int $cast_id
 * @property string $title
 * @property string $content
 * @property string|null $dir
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Cast $cast
 * @property \App\Model\Entity\DiaryLike[] $diary_likes
 */
class Diary extends Entity
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
        'cast_id' => true,
        'title' => true,
        'content' => true,
        'dir' => true,
        'created' => true,
        'modified' => true,
        'cast' => true,
        'diary_likes' => true,
    ];

    /**
     * ƒe[ƒuƒ‹–¼‚ğ•Ô‹p‚·‚é
     *
     *
     * @return void
     */
    protected function _getRegistryAlias()
    {
        return $this->_registryAlias;
    }
}
