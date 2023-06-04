<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccessWeek Entity
 *
 * @property int $id
 * @property int $shop_id
 * @property int $owner_id
 * @property string $name
 * @property string $area
 * @property string $genre
 * @property string $pagePath
 * @property int|null $monday_sessions
 * @property int|null $monday_pageviews
 * @property int|null $monday_users
 * @property int|null $tuesday_sessions
 * @property int|null $tuesday_pageviews
 * @property int|null $tuesday_users
 * @property int|null $wednesday_sessions
 * @property int|null $wednesday_pageviews
 * @property int|null $wednesday_users
 * @property int|null $thursday_sessions
 * @property int|null $thursday_pageviews
 * @property int|null $thursday_users
 * @property int|null $friday_sessions
 * @property int|null $friday_pageviews
 * @property int|null $friday_users
 * @property int|null $saturday_sessions
 * @property int|null $saturday_pageviews
 * @property int|null $saturday_users
 * @property int|null $sunday_sessions
 * @property int|null $sunday_pageviews
 * @property int|null $sunday_users
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Owner $owner
 */
class AccessWeek extends Entity
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
        'name' => true,
        'area' => true,
        'genre' => true,
        'pagePath' => true,
        'monday_sessions' => true,
        'monday_pageviews' => true,
        'monday_users' => true,
        'tuesday_sessions' => true,
        'tuesday_pageviews' => true,
        'tuesday_users' => true,
        'wednesday_sessions' => true,
        'wednesday_pageviews' => true,
        'wednesday_users' => true,
        'thursday_sessions' => true,
        'thursday_pageviews' => true,
        'thursday_users' => true,
        'friday_sessions' => true,
        'friday_pageviews' => true,
        'friday_users' => true,
        'saturday_sessions' => true,
        'saturday_pageviews' => true,
        'saturday_users' => true,
        'sunday_sessions' => true,
        'sunday_pageviews' => true,
        'sunday_users' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'owner' => true,
    ];
}
