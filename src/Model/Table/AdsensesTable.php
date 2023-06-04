<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Adsenses Model
 *
 * @property \App\Model\Table\OwnersTable&\Cake\ORM\Association\BelongsTo $Owners
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 *
 * @method \App\Model\Entity\Adsense get($primaryKey, $options = [])
 * @method \App\Model\Entity\Adsense newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Adsense[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Adsense|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adsense saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adsense patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Adsense[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Adsense findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdsensesTable extends Table
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

        $this->setTable('adsenses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Owners', [
            'foreignKey' => 'owner_id',
            'joinType' => 'INNER',
        ]);
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
            ->scalar('type')
            ->maxLength('type', 20)
            ->allowEmptyString('type');

        $validator
            ->scalar('area')
            ->maxLength('area', 20)
            ->allowEmptyString('area');

        $validator
            ->scalar('genre')
            ->maxLength('genre', 20)
            ->allowEmptyString('genre');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->scalar('catch')
            ->maxLength('catch', 100)
            ->allowEmptyString('catch');

        $validator
            ->date('valid_start')
            ->requirePresence('valid_start', 'create')
            ->notEmptyDate('valid_start');

        $validator
            ->date('valid_end')
            ->requirePresence('valid_end', 'create')
            ->notEmptyDate('valid_end');

        $validator
            ->integer('top_show_flg')
            ->requirePresence('top_show_flg', 'create')
            ->notEmptyString('top_show_flg');

        $validator
            ->integer('area_show_flg')
            ->requirePresence('area_show_flg', 'create')
            ->notEmptyString('area_show_flg');

        $validator
            ->integer('top_order')
            ->allowEmptyString('top_order');

        $validator
            ->integer('area_order')
            ->allowEmptyString('area_order');

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
        $rules->add($rules->existsIn(['shop_id'], 'Shops'));

        return $rules;
    }
}
