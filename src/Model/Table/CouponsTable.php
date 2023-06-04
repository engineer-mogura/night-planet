<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Coupons Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 *
 * @method \App\Model\Entity\Coupon get($primaryKey, $options = [])
 * @method \App\Model\Entity\Coupon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Coupon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Coupon|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coupon saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CouponsTable extends Table
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

        $this->setTable('coupons');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id',
            'joinType' => 'INNER',
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
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->date('from_day')
            ->notEmpty('from_day', helper::encode('有効開始日を入力してください。'))
            ->requirePresence('from_day', 'create')
            ->notEmptyDateTime('from_day');

        $validator
            ->date('to_day')
            ->notEmpty('to_day', helper::encode('有効終了日を入力してください。'))
            ->requirePresence('to_day', 'create')
            ->notEmptyDateTime('to_day')
            ->greaterThanOrEqualToField('to_day', 'from_day', helper::encode('対象期間の終了日は開始日より後にしてください。'));

        $validator
            ->scalar('title')
            ->notEmpty('title', helper::encode('タイトルを入力してください。'))
            ->maxLength('title', 255, helper::encode('タイトルが長すぎます。'))
            ->minLength('title', 5, helper::encode('タイトルが短すぎます。'))
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->notEmpty('content', helper::encode('内容を入力してください。'))
            ->maxLength('content', 255, helper::encode('内容が長すぎます。'))
            ->minLength('content', 5, helper::encode('内容が短すぎます。'))
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

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
        $rules->add($rules->existsIn(['shop_id'], 'Shops'));

        return $rules;
    }
}
