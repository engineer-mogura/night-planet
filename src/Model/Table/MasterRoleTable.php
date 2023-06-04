<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterRole Model
 *
 * @method \App\Model\Entity\MasterRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MasterRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterRole|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterRole saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterRole findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterRoleTable extends Table
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

        $this->setTable('master_role');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('role')
            ->maxLength('role', 64)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('role_name')
            ->maxLength('role_name', 64)
            ->requirePresence('role_name', 'create')
            ->notEmptyString('role_name');

        return $validator;
    }
}
