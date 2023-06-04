<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterCodes Model
 *
 * @method \App\Model\Entity\MasterCode get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterCode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MasterCode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterCode|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterCode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterCode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterCode findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterCodesTable extends Table
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

        $this->setTable('master_codes');

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
            ->requirePresence('id', 'create')
            ->notEmptyString('id');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->scalar('code_name')
            ->maxLength('code_name', 255)
            ->requirePresence('code_name', 'create')
            ->notEmptyString('code_name');

        $validator
            ->scalar('code_group')
            ->maxLength('code_group', 255)
            ->requirePresence('code_group', 'create')
            ->notEmptyString('code_group');

        $validator
            ->integer('sort')
            ->requirePresence('sort', 'create')
            ->notEmptyString('sort');

        $validator
            ->scalar('delete_flag')
            ->maxLength('delete_flag', 1)
            ->allowEmptyString('delete_flag');

        return $validator;
    }
}
