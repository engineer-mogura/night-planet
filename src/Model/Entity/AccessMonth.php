<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccessMonth Entity
 *
 * @property int $id
 * @property string $ym
 * @property int $shop_id
 * @property int $owner_id
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
 * @property int|null $13_sessions
 * @property int|null $13_pageviews
 * @property int|null $13_users
 * @property int|null $14_sessions
 * @property int|null $14_pageviews
 * @property int|null $14_users
 * @property int|null $15_sessions
 * @property int|null $15_pageviews
 * @property int|null $15_users
 * @property int|null $16_sessions
 * @property int|null $16_pageviews
 * @property int|null $16_users
 * @property int|null $17_sessions
 * @property int|null $17_pageviews
 * @property int|null $17_users
 * @property int|null $18_sessions
 * @property int|null $18_pageviews
 * @property int|null $18_users
 * @property int|null $19_sessions
 * @property int|null $19_pageviews
 * @property int|null $19_users
 * @property int|null $20_sessions
 * @property int|null $20_pageviews
 * @property int|null $20_users
 * @property int|null $21_sessions
 * @property int|null $21_pageviews
 * @property int|null $21_users
 * @property int|null $22_sessions
 * @property int|null $22_pageviews
 * @property int|null $22_users
 * @property int|null $23_sessions
 * @property int|null $23_pageviews
 * @property int|null $23_users
 * @property int|null $24_sessions
 * @property int|null $24_pageviews
 * @property int|null $24_users
 * @property int|null $25_sessions
 * @property int|null $25_pageviews
 * @property int|null $25_users
 * @property int|null $26_sessions
 * @property int|null $26_pageviews
 * @property int|null $26_users
 * @property int|null $27_sessions
 * @property int|null $27_pageviews
 * @property int|null $27_users
 * @property int|null $28_sessions
 * @property int|null $28_pageviews
 * @property int|null $28_users
 * @property int|null $29_sessions
 * @property int|null $29_pageviews
 * @property int|null $29_users
 * @property int|null $30_sessions
 * @property int|null $30_pageviews
 * @property int|null $30_users
 * @property int|null $31_sessions
 * @property int|null $31_pageviews
 * @property int|null $31_users
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Shop $shop
 * @property \App\Model\Entity\Owner $owner
 */
class AccessMonth extends Entity {
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
        'ym' => true,
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
        '13_sessions' => true,
        '13_pageviews' => true,
        '13_users' => true,
        '14_sessions' => true,
        '14_pageviews' => true,
        '14_users' => true,
        '15_sessions' => true,
        '15_pageviews' => true,
        '15_users' => true,
        '16_sessions' => true,
        '16_pageviews' => true,
        '16_users' => true,
        '17_sessions' => true,
        '17_pageviews' => true,
        '17_users' => true,
        '18_sessions' => true,
        '18_pageviews' => true,
        '18_users' => true,
        '19_sessions' => true,
        '19_pageviews' => true,
        '19_users' => true,
        '20_sessions' => true,
        '20_pageviews' => true,
        '20_users' => true,
        '21_sessions' => true,
        '21_pageviews' => true,
        '21_users' => true,
        '22_sessions' => true,
        '22_pageviews' => true,
        '22_users' => true,
        '23_sessions' => true,
        '23_pageviews' => true,
        '23_users' => true,
        '24_sessions' => true,
        '24_pageviews' => true,
        '24_users' => true,
        '25_sessions' => true,
        '25_pageviews' => true,
        '25_users' => true,
        '26_sessions' => true,
        '26_pageviews' => true,
        '26_users' => true,
        '27_sessions' => true,
        '27_pageviews' => true,
        '27_users' => true,
        '28_sessions' => true,
        '28_pageviews' => true,
        '28_users' => true,
        '29_sessions' => true,
        '29_pageviews' => true,
        '29_users' => true,
        '30_sessions' => true,
        '30_pageviews' => true,
        '30_users' => true,
        '31_sessions' => true,
        '31_pageviews' => true,
        '31_users' => true,
        'created' => true,
        'modified' => true,
        'shop' => true,
        'owner' => true,
    ];
}
