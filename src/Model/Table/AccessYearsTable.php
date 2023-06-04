<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * AccessYears Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 *
 * @method \App\Model\Entity\AccessYear get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessYear newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessYear[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessYear|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessYear saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessYear patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessYear[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessYear findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessYearsTable extends Table
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

        $this->setTable('access_years');
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
            ->scalar('y')
            ->maxLength('y', 20)
            ->requirePresence('y', 'create')
            ->notEmptyString('y');

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
