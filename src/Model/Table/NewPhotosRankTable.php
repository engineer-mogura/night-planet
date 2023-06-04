<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * NewPhotosRank Model
 *
 * @method \App\Model\Entity\NewPhotosRank get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewPhotosRank newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewPhotosRank[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewPhotosRank|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewPhotosRank saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewPhotosRank patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewPhotosRank[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewPhotosRank findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NewPhotosRankTable extends Table
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

        $this->setTable('new_photos_rank');
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
            ->scalar('like_count')
            ->maxLength('like_count', 255)
            ->requirePresence('like_count', 'create')
            ->notEmptyString('like_count');

        $validator
            ->integer('is_insta')
            ->requirePresence('is_insta', 'create')
            ->notEmptyString('is_insta');

        $validator
            ->scalar('media_type')
            ->maxLength('media_type', 50)
            ->requirePresence('media_type', 'create')
            ->notEmptyString('media_type');

        $validator
            ->scalar('comments_count')
            ->maxLength('comments_count', 255)
            ->requirePresence('comments_count', 'create')
            ->notEmptyString('comments_count');

        $validator
            ->scalar('photo_path')
            ->maxLength('photo_path', 712)
            ->requirePresence('photo_path', 'create')
            ->notEmptyString('photo_path');

        $validator
            ->scalar('details')
            ->maxLength('details', 255)
            ->requirePresence('details', 'create')
            ->notEmptyString('details');

        $validator
            ->scalar('content')
            ->maxLength('content', 355)
            ->allowEmptyString('content');

        $validator
            ->dateTime('post_date')
            ->allowEmptyDateTime('post_date');

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

        return $rules;
    }
}
