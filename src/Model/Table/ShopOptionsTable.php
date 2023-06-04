<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOptions Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 *
 * @method \App\Model\Entity\ShopOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShopOption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShopOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShopOption|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShopOption saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShopOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShopOption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShopOption findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOptionsTable extends Table
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

        $this->setTable('shop_options');
        $this->setDisplayField('id');
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
            ->scalar('menu_color')
            ->maxLength('menu_color', 20)
            ->allowEmptyString('menu_color');

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
