<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\CastLikesTable&\Cake\ORM\Association\HasMany $CastLikes
 * @property \App\Model\Table\DiaryLikesTable&\Cake\ORM\Association\HasMany $DiaryLikes
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\ShopInfoLikesTable&\Cake\ORM\Association\HasMany $ShopInfoLikes
 * @property \App\Model\Table\ShopLikesTable&\Cake\ORM\Association\HasMany $ShopLikes
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CastLikes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('DiaryLikes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShopInfoLikes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShopLikes', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
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
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

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
     * バリデーション ログイン.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUserLogin(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email', 'メールアドレスを入力してください。')
            ->allowEmptyString('email', false);

        $validator
            ->scalar('password')
            ->maxLength('password', 32, 'パスワードが長すぎます。')
            ->minLength('password', 8, 'パスワードが短すぎます。')
            ->notEmpty('password', 'パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * バリデーション プロフィール変更用.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationProfile(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name', helper::encode('名前を入力してください。'))
            ->maxLength('name', 30, helper::encode('名前が長すぎます。'))
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->date('birthday')
            ->allowEmptyTime('birthday');

        $validator
            ->scalar('message')
            ->maxLength('message', 50, helper::encode('メッセージが長すぎます。'))
            ->allowEmptyString('message', true);

        return $validator;
    }

    /**
     * バリデーション パスワードリセット.その１
     * パスワードリセットで使用
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUserPassReset1(Validator $validator) {
        $validator
            ->email('email', false, "メールアドレスの形式が不正です。")
            ->notEmpty('email', 'メールアドレスを入力してください。')
            ->add('email', [
                'exists' => [
                    'rule' => function ($value, $context) {
                        return TableRegistry::get('users')->exists(['email' => $value]);
                    },
                    'message' => 'そのメールアドレスは登録されてません。'
                ],
            ]);

        return $validator;
    }

    /**
     * バリデーション パスワードリセット.その２
     * パスワードリセットで使用
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUserPassReset2(Validator $validator) {
        $validator
            ->scalar('password')
            ->maxLength('password', 32, 'パスワードが長すぎます。')
            ->minLength('password', 8, 'パスワードが短すぎます。')
            ->notEmpty('password', 'パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        return $validator;
    }

    /**
     * バリデーション パスワードリセット.その３
     * パスワード変更で使用
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUserPassReset3(Validator $validator) {
        $validator
            ->scalar('password')
            ->maxLength('password', 32, 'パスワードが長すぎます。')
            ->minLength('password', 8, 'パスワードが短すぎます。')
            ->notEmpty('password', 'パスワードを入力してください。')
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->scalar('password_new')
            ->maxLength('password_new', 32, 'パスワードが長すぎます。')
            ->minLength('password_new', 8, 'パスワードが短すぎます。')
            ->notEmpty('password_new', 'パスワードを入力してください。')
            ->requirePresence('password_new', 'create')
            ->allowEmptyString('password_new', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        //$rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
