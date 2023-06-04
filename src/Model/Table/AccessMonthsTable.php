<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * AccessMonths Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 *
 * @method \App\Model\Entity\AccessMonth get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessMonth newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessMonth[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessMonth|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessMonth saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessMonth patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessMonth[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessMonth findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessMonthsTable extends Table
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

        $this->setTable('access_months');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Casts', [
            'foreignKey' => 'cast_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Owners', [
            'foreignKey' => 'owner_id',
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
            ->scalar('ym')
            ->maxLength('ym', 20)
            ->requirePresence('ym', 'create')
            ->notEmptyString('ym');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('area')
            ->maxLength('area', 255)
            ->requirePresence('area', 'create')
            ->notEmptyString('area');

        $validator
            ->scalar('genre')
            ->maxLength('genre', 255)
            ->requirePresence('genre', 'create')
            ->notEmptyString('genre');

        $validator
            ->scalar('pagePath')
            ->maxLength('pagePath', 255)
            ->requirePresence('pagePath', 'create')
            ->notEmptyString('pagePath');

        $validator
            ->integer('1_sessions')
            ->allowEmptyString('1_sessions');

        $validator
            ->integer('1_pageviews')
            ->allowEmptyString('1_pageviews');

        $validator
            ->integer('1_users')
            ->allowEmptyString('1_users');

        $validator
            ->integer('2_sessions')
            ->allowEmptyString('2_sessions');

        $validator
            ->integer('2_pageviews')
            ->allowEmptyString('2_pageviews');

        $validator
            ->integer('2_users')
            ->allowEmptyString('2_users');

        $validator
            ->integer('3_sessions')
            ->allowEmptyString('3_sessions');

        $validator
            ->integer('3_pageviews')
            ->allowEmptyString('3_pageviews');

        $validator
            ->integer('3_users')
            ->allowEmptyString('3_users');

        $validator
            ->integer('4_sessions')
            ->allowEmptyString('4_sessions');

        $validator
            ->integer('4_pageviews')
            ->allowEmptyString('4_pageviews');

        $validator
            ->integer('4_users')
            ->allowEmptyString('4_users');

        $validator
            ->integer('5_sessions')
            ->allowEmptyString('5_sessions');

        $validator
            ->integer('5_pageviews')
            ->allowEmptyString('5_pageviews');

        $validator
            ->integer('5_users')
            ->allowEmptyString('5_users');

        $validator
            ->integer('6_sessions')
            ->allowEmptyString('6_sessions');

        $validator
            ->integer('6_pageviews')
            ->allowEmptyString('6_pageviews');

        $validator
            ->integer('6_users')
            ->allowEmptyString('6_users');

        $validator
            ->integer('7_sessions')
            ->allowEmptyString('7_sessions');

        $validator
            ->integer('7_pageviews')
            ->allowEmptyString('7_pageviews');

        $validator
            ->integer('7_users')
            ->allowEmptyString('7_users');

        $validator
            ->integer('8_sessions')
            ->allowEmptyString('8_sessions');

        $validator
            ->integer('8_pageviews')
            ->allowEmptyString('8_pageviews');

        $validator
            ->integer('8_users')
            ->allowEmptyString('8_users');

        $validator
            ->integer('9_sessions')
            ->allowEmptyString('9_sessions');

        $validator
            ->integer('9_pageviews')
            ->allowEmptyString('9_pageviews');

        $validator
            ->integer('9_users')
            ->allowEmptyString('9_users');

        $validator
            ->integer('10_sessions')
            ->allowEmptyString('10_sessions');

        $validator
            ->integer('10_pageviews')
            ->allowEmptyString('10_pageviews');

        $validator
            ->integer('10_users')
            ->allowEmptyString('10_users');

        $validator
            ->integer('11_sessions')
            ->allowEmptyString('11_sessions');

        $validator
            ->integer('11_pageviews')
            ->allowEmptyString('11_pageviews');

        $validator
            ->integer('11_users')
            ->allowEmptyString('11_users');

        $validator
            ->integer('12_sessions')
            ->allowEmptyString('12_sessions');

        $validator
            ->integer('12_pageviews')
            ->allowEmptyString('12_pageviews');

        $validator
            ->integer('12_users')
            ->allowEmptyString('12_users');

        $validator
            ->integer('13_sessions')
            ->allowEmptyString('13_sessions');

        $validator
            ->integer('13_pageviews')
            ->allowEmptyString('13_pageviews');

        $validator
            ->integer('13_users')
            ->allowEmptyString('13_users');

        $validator
            ->integer('14_sessions')
            ->allowEmptyString('14_sessions');

        $validator
            ->integer('14_pageviews')
            ->allowEmptyString('14_pageviews');

        $validator
            ->integer('14_users')
            ->allowEmptyString('14_users');

        $validator
            ->integer('15_sessions')
            ->allowEmptyString('15_sessions');

        $validator
            ->integer('15_pageviews')
            ->allowEmptyString('15_pageviews');

        $validator
            ->integer('15_users')
            ->allowEmptyString('15_users');

        $validator
            ->integer('16_sessions')
            ->allowEmptyString('16_sessions');

        $validator
            ->integer('16_pageviews')
            ->allowEmptyString('16_pageviews');

        $validator
            ->integer('16_users')
            ->allowEmptyString('16_users');

        $validator
            ->integer('17_sessions')
            ->allowEmptyString('17_sessions');

        $validator
            ->integer('17_pageviews')
            ->allowEmptyString('17_pageviews');

        $validator
            ->integer('17_users')
            ->allowEmptyString('17_users');

        $validator
            ->integer('18_sessions')
            ->allowEmptyString('18_sessions');

        $validator
            ->integer('18_pageviews')
            ->allowEmptyString('18_pageviews');

        $validator
            ->integer('18_users')
            ->allowEmptyString('18_users');

        $validator
            ->integer('19_sessions')
            ->allowEmptyString('19_sessions');

        $validator
            ->integer('19_pageviews')
            ->allowEmptyString('19_pageviews');

        $validator
            ->integer('19_users')
            ->allowEmptyString('19_users');

        $validator
            ->integer('20_sessions')
            ->allowEmptyString('20_sessions');

        $validator
            ->integer('20_pageviews')
            ->allowEmptyString('20_pageviews');

        $validator
            ->integer('20_users')
            ->allowEmptyString('20_users');

        $validator
            ->integer('21_sessions')
            ->allowEmptyString('21_sessions');

        $validator
            ->integer('21_pageviews')
            ->allowEmptyString('21_pageviews');

        $validator
            ->integer('21_users')
            ->allowEmptyString('21_users');

        $validator
            ->integer('22_sessions')
            ->allowEmptyString('22_sessions');

        $validator
            ->integer('22_pageviews')
            ->allowEmptyString('22_pageviews');

        $validator
            ->integer('22_users')
            ->allowEmptyString('22_users');

        $validator
            ->integer('23_sessions')
            ->allowEmptyString('23_sessions');

        $validator
            ->integer('23_pageviews')
            ->allowEmptyString('23_pageviews');

        $validator
            ->integer('23_users')
            ->allowEmptyString('23_users');

        $validator
            ->integer('24_sessions')
            ->allowEmptyString('24_sessions');

        $validator
            ->integer('24_pageviews')
            ->allowEmptyString('24_pageviews');

        $validator
            ->integer('24_users')
            ->allowEmptyString('24_users');

        $validator
            ->integer('25_sessions')
            ->allowEmptyString('25_sessions');

        $validator
            ->integer('25_pageviews')
            ->allowEmptyString('25_pageviews');

        $validator
            ->integer('25_users')
            ->allowEmptyString('25_users');

        $validator
            ->integer('26_sessions')
            ->allowEmptyString('26_sessions');

        $validator
            ->integer('26_pageviews')
            ->allowEmptyString('26_pageviews');

        $validator
            ->integer('26_users')
            ->allowEmptyString('26_users');

        $validator
            ->integer('27_sessions')
            ->allowEmptyString('27_sessions');

        $validator
            ->integer('27_pageviews')
            ->allowEmptyString('27_pageviews');

        $validator
            ->integer('27_users')
            ->allowEmptyString('27_users');

        $validator
            ->integer('28_sessions')
            ->allowEmptyString('28_sessions');

        $validator
            ->integer('28_pageviews')
            ->allowEmptyString('28_pageviews');

        $validator
            ->integer('28_users')
            ->allowEmptyString('28_users');

        $validator
            ->integer('29_sessions')
            ->allowEmptyString('29_sessions');

        $validator
            ->integer('29_pageviews')
            ->allowEmptyString('29_pageviews');

        $validator
            ->integer('29_users')
            ->allowEmptyString('29_users');

        $validator
            ->integer('30_sessions')
            ->allowEmptyString('30_sessions');

        $validator
            ->integer('30_pageviews')
            ->allowEmptyString('30_pageviews');

        $validator
            ->integer('30_users')
            ->allowEmptyString('30_users');

        $validator
            ->integer('31_sessions')
            ->allowEmptyString('31_sessions');

        $validator
            ->integer('31_pageviews')
            ->allowEmptyString('31_pageviews');

        $validator
            ->integer('31_users')
            ->allowEmptyString('31_users');

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
        $rules->add($rules->existsIn(['cast_id'], 'Casts'));
        $rules->add($rules->existsIn(['owner_id'], 'Owners'));

        return $rules;
    }
}
