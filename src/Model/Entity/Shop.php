<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shop Entity
 *
 * @property int $id
 * @property int $owner_id
 * @property string|null $area
 * @property string|null $genre
 * @property string|null $dir
 * @property string|null $name
 * @property string|null $catch
 * @property string|null $tel
 * @property string|null $web_site
 * @property \Cake\I18n\FrozenTime|null $bus_from_time
 * @property \Cake\I18n\FrozenTime|null $bus_to_time
 * @property string|null $bus_hosoku
 * @property string|null $system
 * @property string|null $credit
 * @property string|null $pref21
 * @property string|null $addr21
 * @property string|null $strt21
 * @property int|null $status
 * @property int|null $delete_flag
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Owner $owner
 * @property \App\Model\Entity\AccessMonth[] $access_months
 * @property \App\Model\Entity\AccessWeek[] $access_weeks
 * @property \App\Model\Entity\AccessYear[] $access_years
 * @property \App\Model\Entity\Adsense[] $adsenses
 * @property \App\Model\Entity\CastSchedule[] $cast_schedules
 * @property \App\Model\Entity\Cast[] $casts
 * @property \App\Model\Entity\Coupon[] $coupons
 * @property \App\Model\Entity\Job[] $jobs
 * @property \App\Model\Entity\Review[] $reviews
 * @property \App\Model\Entity\ShopInfo[] $shop_infos
 * @property \App\Model\Entity\ShopLike[] $shop_likes
 * @property \App\Model\Entity\ShopOption[] $shop_options
 * @property \App\Model\Entity\Sns[] $snss
 * @property \App\Model\Entity\Tmp[] $tmps
 * @property \App\Model\Entity\Update[] $updates
 * @property \App\Model\Entity\WorkSchedule[] $work_schedules
 */
class Shop extends Entity
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
        'owner_id' => true,
        'area' => true,
        'genre' => true,
        'dir' => true,
        'name' => true,
        'catch' => true,
        'tel' => true,
        'bus_from_time' => true,
        'bus_to_time' => true,
        'bus_hosoku' => true,
        'web_site' => true,
        'shop_system' => true,
        'credit' => true,
        'pref21' => true,
        'addr21' => true,
        'strt21' => true,
        'status' => true,
        'delete_flag' => true,
        'created' => true,
        'modified' => true,
        'owner' => true,
        'access_months' => true,
        'access_weeks' => true,
        'access_years' => true,
        'adsenses' => true,
        'cast_schedules' => true,
        'casts' => true,
        'coupons' => true,
        'jobs' => true,
        'reviews' => true,
        'shop_infos' => true,
        'shop_likes' => true,
        'shop_options' => true,
        'snss' => true,
        'tmps' => true,
        'updates' => true,
        'work_schedules' => true,
    ];

    /**
     * フルアドレスを返却する
     *
     *
     * @return void
     */
    protected function _getFullAddress()
    {
        return $this->_properties['pref21'] .
            $this->_properties['addr21'] . $this->_properties['strt21'];
    }

    /**
     * テーブル名を返却する
     *
     *
     * @return void
     */
    protected function _getRegistryAlias()
    {
        return $this->_registryAlias;
    }
}
