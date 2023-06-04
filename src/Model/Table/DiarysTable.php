<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Diarys Model
 *
 * @property \App\Model\Table\CastsTable&\Cake\ORM\Association\BelongsTo $Casts
 * @property \App\Model\Table\DiaryLikesTable&\Cake\ORM\Association\HasMany $DiaryLikes
 *
 * @method \App\Model\Entity\Diary get($primaryKey, $options = [])
 * @method \App\Model\Entity\Diary newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Diary[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Diary|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diary saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Diary patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Diary[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Diary findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiarysTable extends Table
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

        $this->setTable('diarys');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Casts', [
            'foreignKey' => 'cast_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DiaryLikes', [
            'foreignKey' => 'diary_id',
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
            ->scalar('title')
            ->maxLength('title', 50, 'タイトルが長すぎます。')
            ->requirePresence('title', 'create')
            ->notEmptyString('title', 'タイトルを入力してください。');

        $validator
            ->scalar('content')
            ->maxLength('content', 600, '内容が長すぎます。')
            ->requirePresence('content', 'create')
            ->notEmptyString('content', '内容を入力してください。');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->allowEmptyString('dir');

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
        $rules->add($rules->existsIn(['cast_id'], 'casts'));

        return $rules;
    }
}
