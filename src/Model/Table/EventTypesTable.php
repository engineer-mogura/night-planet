<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventTypes Model
 *
 * @property \App\Model\Table\CastSchedulesTable&\Cake\ORM\Association\HasMany $CastSchedules
 *
 * @method \App\Model\Entity\EventType get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventType findOrCreate($search, callable $callback = null, $options = [])
 */
class EventTypesTable extends Table
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

        $this->setTable('event_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CastSchedules', [
            'foreignKey' => 'event_type_id',
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
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->requirePresence('color', 'create')
            ->notEmptyString('color');

        return $validator;
    }
}
