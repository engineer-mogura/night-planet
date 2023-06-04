<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * AccessWeeks Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 *
 * @method \App\Model\Entity\AccessWeek get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessWeek newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessWeek[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessWeek|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessWeek saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessWeek patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessWeek[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessWeek findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessWeeksTable extends Table
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

        $this->setTable('access_weeks');
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
            ->integer('monday_sessions')
            ->allowEmptyString('monday_sessions');

        $validator
            ->integer('monday_pageviews')
            ->allowEmptyString('monday_pageviews');

        $validator
            ->integer('monday_users')
            ->allowEmptyString('monday_users');

        $validator
            ->integer('tuesday_sessions')
            ->allowEmptyString('tuesday_sessions');

        $validator
            ->integer('tuesday_pageviews')
            ->allowEmptyString('tuesday_pageviews');

        $validator
            ->integer('tuesday_users')
            ->allowEmptyString('tuesday_users');

        $validator
            ->integer('wednesday_sessions')
            ->allowEmptyString('wednesday_sessions');

        $validator
            ->integer('wednesday_pageviews')
            ->allowEmptyString('wednesday_pageviews');

        $validator
            ->integer('wednesday_users')
            ->allowEmptyString('wednesday_users');

        $validator
            ->integer('thursday_sessions')
            ->allowEmptyString('thursday_sessions');

        $validator
            ->integer('thursday_pageviews')
            ->allowEmptyString('thursday_pageviews');

        $validator
            ->integer('thursday_users')
            ->allowEmptyString('thursday_users');

        $validator
            ->integer('friday_sessions')
            ->allowEmptyString('friday_sessions');

        $validator
            ->integer('friday_pageviews')
            ->allowEmptyString('friday_pageviews');

        $validator
            ->integer('friday_users')
            ->allowEmptyString('friday_users');

        $validator
            ->integer('saturday_sessions')
            ->allowEmptyString('saturday_sessions');

        $validator
            ->integer('saturday_pageviews')
            ->allowEmptyString('saturday_pageviews');

        $validator
            ->integer('saturday_users')
            ->allowEmptyString('saturday_users');

        $validator
            ->integer('sunday_sessions')
            ->allowEmptyString('sunday_sessions');

        $validator
            ->integer('sunday_pageviews')
            ->allowEmptyString('sunday_pageviews');

        $validator
            ->integer('sunday_users')
            ->allowEmptyString('sunday_users');

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
