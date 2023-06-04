<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Snss Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\CastsTable&\Cake\ORM\Association\BelongsTo $Casts
 *
 * @method \App\Model\Entity\Sns get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sns newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sns[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sns|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sns saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sns patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sns[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sns findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SnssTable extends Table
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

        $this->setTable('snss');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('shops', [
            'foreignKey' => 'shop_id',
        ]);
        $this->belongsTo('casts', [
            'foreignKey' => 'cast_id',
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
            ->scalar('facebook')
            ->maxLength('facebook', 255)
            ->allowEmptyString('facebook');

        $validator
            ->scalar('twitter')
            ->maxLength('twitter', 255)
            ->allowEmptyString('twitter');

        $validator
            ->scalar('instagram')
            ->maxLength('instagram', 255)
            ->allowEmptyString('instagram');

        $validator
            ->scalar('line')
            ->maxLength('line', 255)
            ->allowEmptyString('line');

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
        $rules->add($rules->existsIn(['cast_id'], 'casts'));

        return $rules;
    }
}
