<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ServecePlans Model
 *
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 *
 * @method \App\Model\Entity\ServecePlan get($primaryKey, $options = [])
 * @method \App\Model\Entity\ServecePlan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ServecePlan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ServecePlan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServecePlan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServecePlan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ServecePlan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ServecePlan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ServecePlansTable extends Table
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

        $this->setTable('servece_plans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('current_plan')
            ->maxLength('current_plan', 20)
            ->requirePresence('current_plan', 'create')
            ->notEmptyString('current_plan');

        $validator
            ->scalar('previous_plan')
            ->maxLength('previous_plan', 20)
            ->requirePresence('previous_plan', 'create')
            ->notEmptyString('previous_plan');

        $validator
            ->integer('course')
            ->requirePresence('course', 'create')
            ->notEmptyString('course');

        $validator
            ->date('from_start')
            ->requirePresence('from_start', 'create')
            ->notEmptyDate('from_start');

        $validator
            ->date('to_end')
            ->requirePresence('to_end', 'create')
            ->notEmptyDate('to_end');

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
