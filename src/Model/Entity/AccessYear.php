<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccessYear Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property int $owner_id
 * @property string $y
 * @property string $name
 * @property string $area
 * @property string $genre
 * @property string $pagePath
 * @property int|null $1_sessions
 * @property int|null $1_pageviews
 * @property int|null $1_users
 * @property int|null $2_sessions
 * @property int|null $2_pageviews
 * @property int|null $2_users
 * @property int|null $3_sessions
 * @property int|null $3_pageviews
 * @property int|null $3_users
 * @property int|null $4_sessions
 * @property int|null $4_pageviews
 * @property int|null $4_users
 * @property int|null $5_sessions
 * @property int|null $5_pageviews
 * @property int|null $5_users
 * @property int|null $6_sessions
 * @property int|null $6_pageviews
 * @property int|null $6_users
 * @property int|null $7_sessions
 * @property int|null $7_pageviews
 * @property int|null $7_users
 * @property int|null $8_sessions
 * @property int|null $8_pageviews
 * @property int|null $8_users
 * @property int|null $9_sessions
 * @property int|null $9_pageviews
 * @property int|null $9_users
 * @property int|null $10_sessions
 * @property int|null $10_pageviews
 * @property int|null $10_users
 * @property int|null $11_sessions
 * @property int|null $11_pageviews
 * @property int|null $11_users
 * @property int|null $12_sessions
 * @property int|null $12_pageviews
 * @property int|null $12_users
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Owner $owner
 */
class AccessYear extends Entity
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
        'shop_id' => true,
        'cast_id' => true,
        'owner_id' => true,
        'y' => true,
        'name' => true,
        'area' => true,
        'genre' => true,
        'pagePath' => true,
        '1_sessions' => true,
        '1_pageviews' => true,
        '1_users' => true,
        '2_sessions' => true,
        '2_pageviews' => true,
        '2_users' => true,
        '3_sessions' => true,
        '3_pageviews' => true,
        '3_users' => true,
        '4_sessions' => true,
        '4_pageviews' => true,
        '4_users' => true,
        '5_sessions' => true,
        '5_pageviews' => true,
        '5_users' => true,
        '6_sessions' => true,
        '6_pageviews' => true,
        '6_users' => true,
        '7_sessions' => true,
        '7_pageviews' => true,
        '7_users' => true,
        '8_sessions' => true,
        '8_pageviews' => true,
        '8_users' => true,
        '9_sessions' => true,
        '9_pageviews' => true,
        '9_users' => true,
        '10_sessions' => true,
        '10_pageviews' => true,
        '10_users' => true,
        '11_sessions' => true,
        '11_pageviews' => true,
        '11_users' => true,
        '12_sessions' => true,
        '12_pageviews' => true,
        '12_users' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'owner' => true,
    ];
}
