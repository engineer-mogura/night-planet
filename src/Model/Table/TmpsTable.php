<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Tmps Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 *
 * @method \App\Model\Entity\Tmp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tmp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tmp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tmp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tmp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tmp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tmp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tmp findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TmpsTable extends Table
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

        $this->setTable('tmps');
        $this->setDisplayField('name');
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
            ->scalar('nickname')
            ->maxLength('nickname', 30)
            ->requirePresence('nickname', 'create')
            ->notEmptyString('nickname');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 15)
            ->requirePresence('tel', 'create')
            ->notEmptyString('tel');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->dateTime('birthday')
            ->allowEmptyDateTime('birthday');

        $validator
            ->scalar('three_size')
            ->maxLength('three_size', 10)
            ->allowEmptyString('three_size');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

        $validator
            ->scalar('age')
            ->maxLength('age', 5)
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->scalar('blood_type')
            ->maxLength('blood_type', 20)
            ->allowEmptyString('blood_type');

        $validator
            ->scalar('constellation')
            ->maxLength('constellation', 20)
            ->allowEmptyString('constellation');

        $validator
            ->scalar('message')
            ->maxLength('message', 50)
            ->allowEmptyString('message');

        $validator
            ->scalar('holiday')
            ->maxLength('holiday', 50)
            ->allowEmptyString('holiday');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->allowEmptyString('dir');

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
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->integer('delete_flag')
            ->allowEmptyString('delete_flag');

        return $validator;
    }

    /**
     * オーナー バリデーション 新規登録.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationOwnerRegistration(Validator $validator)
    {

        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name','名前を入力してください。')
            ->maxLength('name', 45, '名前が長すぎます。')
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->allowEmptyString('role', false);

        $validator
            ->email('email',false, 'メールアドレスの形式が不正です。')
            ->requirePresence('email', 'create')
            ->notEmpty('email','メールアドレスを入力してください。')
            ->allowEmptyString('email', false)
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return !TableRegistry::get('tmps')->exists(['email' => $value]);
                    },
                    'message' => 'そのメールアドレスは既に登録されています。'
                ],
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 32,'パスワードが長すぎます。')
            ->minLength('password', 8,'パスワードが短すぎます。')
            ->notEmpty('password','パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false)
            ->add('password',[  //←バリデーション対象カラム
                    'comWith' => [  //←任意のバリデーション名
                        'rule' => ['compareWith','password_check'],  //←バリデーションのルール
                        'message' => '確認用のパスワードと一致しません。'  //←エラー時のメッセージ
            ]]);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender','性別を選択してください。')
            ->allowEmptyString('gender', false);

        $validator
            ->scalar('age')
            ->maxLength('age', 5)
            ->requirePresence('age', 'create')
            ->notEmpty('age','年齢を選択してください。')
            ->allowEmptyString('age', false);

        $validator
            ->integer('dir');

        $validator
            ->scalar('tel')
            ->requirePresence('tel', 'create')
            ->notEmpty('tel','電話番号を入力してください。')
            ////電話番号形式のチェック ////
            ->add('tel', 'tel_check',[
                'rule' =>'tel_check',
                'provider' => 'custom',
                'message' => '無効な電話番号です。'
            ]);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * スタッフ バリデーション 新規登録.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationCastRegistration(Validator $validator)
    {
        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name','名前を入力してください。')
            ->maxLength('name', 30, '名前が長すぎます。')
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('nickname')
            ->notEmpty('nickname','ニックネームを入力してください。')
            ->maxLength('nickname', 30, 'ニックネームが長すぎます。')
            ->requirePresence('nickname', 'create')
            ->allowEmptyString('nickname', false);

        $validator
            ->email('email',false, 'メールアドレスの形式が不正です。')
            ->notEmpty('email','メールアドレスを入力してください。')
            ->requirePresence('email', 'create')
            ->allowEmptyString('email', false)
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return !TableRegistry::get('tmps')->exists(['email' => $value]);
                    },
                    'message' => 'そのメールアドレスは既に登録されています。'
                ],
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 32,'パスワードが長すぎます。')
            ->minLength('password', 8,'パスワードが短すぎます。')
            ->notEmpty('password','パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->date('birthday')
            ->allowEmptyTime('birthday');

        $validator
            ->scalar('three_size')
            ->maxLength('three_size', 10)
            ->allowEmptyString('three_size');

        $validator
            ->scalar('blood_type')
            ->maxLength('blood_type', 20)
            ->allowEmptyString('blood_type');

        $validator
            ->scalar('constellation')
            ->maxLength('constellation', 20)
            ->allowEmptyString('constellation');

        $validator
            ->scalar('age')
            ->maxLength('age', 5)
            ->allowEmptyString('age');

        $validator
            ->scalar('message')
            ->maxLength('message', 50,'メッセージが長すぎます。')
            ->allowEmptyString('message', false);

        $validator
            ->scalar('holiday')
            ->maxLength('holiday', 50)
            ->allowEmptyString('holiday');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->allowEmptyString('dir');

        $validator
            ->scalar('remember_token')
            ->maxLength('remember_token', 64)
            ->allowEmptyString('remember_token');

        $validator
            ->integer('status')
            ->allowEmptyString('status', false);

        $validator
            ->integer('delete_flag')
            ->allowEmptyString('delete_flag');

        return $validator;
    }

    /**
     * ユーザー バリデーション 新規登録.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUserRegistration(Validator $validator)
    {

        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name','名前を入力してください。')
            ->maxLength('name', 45, '名前が長すぎます。')
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->allowEmptyString('role', false);

        $validator
            ->email('email',false, 'メールアドレスの形式が不正です。')
            ->requirePresence('email', 'create')
            ->notEmpty('email','メールアドレスを入力してください。')
            ->allowEmptyString('email', false)
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return !TableRegistry::get('users')->exists(['email' => $value]);
                    },
                    'message' => 'そのメールアドレスは既に登録されています。'
                ],
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 32,'パスワードが長すぎます。')
            ->minLength('password', 8,'パスワードが短すぎます。')
            ->notEmpty('password','パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false)
            ->add('password',[  //←バリデーション対象カラム
                    'comWith' => [  //←任意のバリデーション名
                        'rule' => ['compareWith','password_check'],  //←バリデーションのルール
                        'message' => '確認用のパスワードと一致しません。'  //←エラー時のメッセージ
            ]]);
        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender','性別を選択してください。')
            ->allowEmptyString('gender', false);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['shop_id'], 'Shops'));

        return $rules;
    }
}
