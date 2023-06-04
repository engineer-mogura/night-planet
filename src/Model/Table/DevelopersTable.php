<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Developers Model
 *
 * @property \App\Model\Table\NewsTable&\Cake\ORM\Association\HasMany $News
 *
 * @method \App\Model\Entity\Developer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Developer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Developer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Developer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Developer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Developer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Developer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Developer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevelopersTable extends Table
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

        $this->setTable('developers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('News', [
            'foreignKey' => 'developer_id',
        ]);
    }

    /**
     * バリデーション ログイン.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDeveloperLogin(Validator $validator)
{
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email,'メールアドレスを入力してください。');

        $validator
            ->scalar('password')
            ->maxLength('password', 255,'パスワードが長すぎます。')
            ->minLength('password', 8,'パスワードが短すぎます。')
            ->requirePresence('password', 'create')
            ->notEmptyString('password','パスワードを入力してください。');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyFile('file_name');

        $validator
            ->scalar('remember_token')
            ->maxLength('remember_token', 64)
            ->allowEmptyString('remember_token');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('delete_flag')
            ->notEmptyString('delete_flag');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
