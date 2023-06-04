<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Shops Model
 *
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 * @property \App\Model\Table\AccessMonthsTable&\Cake\ORM\Association\HasMany $AccessMonths
 * @property \App\Model\Table\AccessWeeksTable&\Cake\ORM\Association\HasMany $AccessWeeks
 * @property \App\Model\Table\AccessYearsTable&\Cake\ORM\Association\HasMany $AccessYears
 * @property \App\Model\Table\AdsensesTable&\Cake\ORM\Association\HasMany $Adsenses
 * @property \App\Model\Table\CastSchedulesTable&\Cake\ORM\Association\HasMany $CastSchedules
 * @property \App\Model\Table\CastsTable&\Cake\ORM\Association\HasMany $Casts
 * @property \App\Model\Table\CouponsTable&\Cake\ORM\Association\HasMany $Coupons
 * @property \App\Model\Table\JobsTable&\Cake\ORM\Association\HasMany $Jobs
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\ShopInfosTable&\Cake\ORM\Association\HasMany $ShopInfos
 * @property \App\Model\Table\ShopLikesTable&\Cake\ORM\Association\HasMany $ShopLikes
 * @property \App\Model\Table\ShopOptionsTable&\Cake\ORM\Association\HasMany $ShopOptions
 * @property \App\Model\Table\SnssTable&\Cake\ORM\Association\HasMany $Snss
 * @property \App\Model\Table\TmpsTable&\Cake\ORM\Association\HasMany $Tmps
 * @property \App\Model\Table\UpdatesTable&\Cake\ORM\Association\HasMany $Updates
 * @property \App\Model\Table\WorkSchedulesTable&\Cake\ORM\Association\HasMany $WorkSchedules
 *
 * @method \App\Model\Entity\Shop get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Shop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shop|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shop saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shop findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('shops');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Owners', [
            'foreignKey' => 'owner_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('AccessMonths', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('AccessWeeks', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('AccessYears', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Adsenses', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('CastSchedules', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Casts', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Coupons', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Jobs', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('ShopInfos', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('ShopLikes', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('ShopOptions', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Snss', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Tmps', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('Updates', [
            'foreignKey' => 'shop_id',
        ]);
        $this->hasMany('WorkSchedules', [
            'foreignKey' => 'shop_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {

        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('area')
            ->maxLength('area', 255)
            ->allowEmptyString('area', helper::encode('�G���A��I�����Ă��������B'));

        $validator
            ->scalar('genre')
            ->maxLength('genre', 255)
            ->allowEmptyString('genre', helper::encode('�X�܂̃W��������I�����Ă��������B'));

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->allowEmptyString('dir');

        $validator
            ->scalar('name')
            ->maxLength('name', 40, helper::encode('�X�ܖ���40�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('name');

        $validator
            ->scalar('catch')
            ->minLength('catch', 5, helper::encode('�L���b�`�R�s�[���Z�����܂��B'))
            ->maxLength('catch', 100, helper::encode('�L���b�`�R�s�[��100�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('catch');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 15, helper::encode('�d�b�ԍ��������ł��B'))
            ->allowEmptyString('tel')
            ////�d�b�ԍ��`���̃`�F�b�N ////
            ->add('tel', 'tel_check',[
                'rule' =>'tel_check',
                'provider' => 'custom',
                'message' => helper::encode('�����ȓd�b�ԍ��ł��B')
            ]);
        $validator
            ->scalar('web_site')
            ->maxLength('web_site', 255, helper::encode('�E�F�u�T�C�g��255�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('web_site');

        $validator
            ->time('bus_from_time')
            ->allowEmptyTime('bus_from_time');

        $validator
            ->time('bus_to_time')
            ->allowEmptyTime('bus_to_time');

        $validator
            ->scalar('bus_hosoku')
            ->maxLength('bus_hosoku', 255, helper::encode('�⑫��120�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('bus_hosoku');

        $validator
            ->scalar('shop_system')
            ->maxLength('shop_system', 900, helper::encode('�V�X�e����900�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('shop_system');

        $validator
            ->scalar('credit')
            ->maxLength('credit', 255)
            ->allowEmptyString('credit');

        $validator
            ->scalar('pref21')
            ->maxLength('pref21', 3, helper::encode('�s���{�����s���ł��B'))
            ->allowEmptyString('pref21');

        $validator
            ->scalar('addr21')
            ->maxLength('addr21', 10, helper::encode('�s�������s���ł��B'))
            ->allowEmptyString('addr21');

        $validator
            ->scalar('strt21')
            ->maxLength('strt21', 30, helper::encode('�ȍ~�̏Z�����s���ł��B'))
            ->allowEmptyString('strt21');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('delete_flag')
            ->allowEmptyString('delete_flag');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['owner_id'], 'Owners'));

        return $rules;
    }
}
