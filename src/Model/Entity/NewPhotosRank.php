<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewPhotosRank Entity
 *
 * @property int $id
 * @property string $name
 * @property string $area
 * @property string $genre
 * @property string $like_count
 * @property int $is_insta
 * @property string $media_type
 * @property string $comments_count
 * @property string $photo_path
 * @property string $details
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime|null $post_date
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class NewPhotosRank extends Entity {
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
        'shop_id' => true,
        'cast_id' => true,
        'name' => true,
        'area' => true,
        'genre' => true,
        'like_count' => true,
        'is_insta' => true,
        'media_type' => true,
        'comments_count' => true,
        'photo_path' => true,
        'details' => true,
        'content' => true,
        'post_date' => true,
        'created' => true,
        'modified' => true,
    ];
}
