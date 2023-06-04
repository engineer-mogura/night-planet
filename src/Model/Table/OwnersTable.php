<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Owners Model
 *
 * @property \App\Model\Table\AccessMonthsTable&\Cake\ORM\Association\HasMany $AccessMonths
 * @property \App\Model\Table\AccessWeeksTable&\Cake\ORM\Association\HasMany $AccessWeeks
 * @property \App\Model\Table\AccessYearsTable&\Cake\ORM\Association\HasMany $AccessYears
 * @property \App\Model\Table\AdsensesTable&\Cake\ORM\Association\HasMany $Adsenses
 * @property \App\Model\Table\ServecePlansTable&\Cake\ORM\Association\HasMany $ServecePlans
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\HasMany $Shops
 *
 * @method \App\Model\Entity\Owner get($primaryKey, $options = [])
 * @method \App\Model\Entity\Owner newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Owner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Owner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Owner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Owner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Owner[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Owner findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OwnersTable extends Table
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

        $this->setTable('owners');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('AccessMonths', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('AccessWeeks', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasMany('AccessYears', [
            'foreignKey' => 'owner_id',
        ]);
        $this->hasOne('ServecePlans', [
            'foreignKey' => 'owner_id'
        ]);
        $this->hasOne('Adsenses', [
            'foreignKey' => 'owner_id'
        ]);
        $this->hasMany('Shops', [
            'foreignKey' => 'owner_id',
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
            ->scalar('tel')
            ->maxLength('tel', 15)
            ->requirePresence('tel', 'create')
            ->notEmptyString('tel');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');
        $validator
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return !TableRegistry::get('Owners')->exists(['email' => $value]);
                    },
                    'message' => helper::encode('そのメールアドレスは既に登録されています。')
                ],
            ]);
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
            ->scalar('age')
            ->maxLength('age', 5)
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->scalar('icon_image_file')
            ->maxLength('icon_image_file', 255)
            ->allowEmptyString('icon_image_file');

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
            ->notEmpty('name', helper::encode('名前を入力してください。'))
            ->maxLength('name', 45, helper::encode('名前が長すぎます。'))
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->allowEmptyString('role', false);

        $validator
            ->email('email',false, helper::encode('メールアドレスの形式が不正です。'))
            ->requirePresence('email', 'create')
            ->notEmpty('email', helper::encode('メールアドレスを入力してください。'))
            ->allowEmptyString('email', false)
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return !TableRegistry::get('Owners')->exists(['email' => $value]);
                    },
                    'message' => helper::encode('そのメールアドレスは既に登録されています。')
                ],
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 32, helper::encode('パスワードが長すぎます。'))
            ->minLength('password', 8, helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password', helper::encode('パスワードを入力してください。'))
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false)
            ->add('password',[  //←バリデーション対象カラム
                    'comWith' => [  //←任意のバリデーション名
                        'rule' => ['compareWith','password_check'],  //←バリデーションのルール
                        'message' => helper::encode('確認用のパスワードと一致しません。')  //←エラー時のメッセージ
            ]]);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender', helper::encode('性別を選択してください。'))
            ->allowEmptyString('gender', false);

        $validator
            ->scalar('age')
            ->maxLength('age', 5)
            ->requirePresence('age', 'create')
            ->notEmpty('age', helper::encode('年齢を選択してください。'))
            ->allowEmptyString('age', false);

        $validator
            ->scalar('icon_image_file')
            ->maxLength('icon_image_file', 255)
            ->allowEmptyString('icon_image_file');

        $validator
            ->scalar('tel')
            ->requirePresence('tel', 'create')
            ->notEmpty('tel', helper::encode('電話番号を入力してください。'))
            ////電話番号形式のチェック ////
            ->add('tel', 'tel_check',[
                'rule' =>'tel_check',
                'provider' => 'custom',
                'message' => helper::encode('無効な電話番号です。')
            ]);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * バリデーション ログイン.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationOwnerLogin(Validator $validator)
{
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email', helper::encode('メールアドレスを入力してください。'))
            ->allowEmptyString('email', false);

        $validator
            ->scalar('password')
            ->maxLength('password', 32, helper::encode('パスワードが長すぎます。'))
            ->minLength('password', 8, helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password', helper::encode('パスワードを入力してください。'))
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * バリデーション パスワードリセット.その１
     * パスワードリセットで使用
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationOwnerPassReset1(Validator $validator)
    {
        $validator
            ->email('email',false, helper::encode('メールアドレスの形式が不正です。'))
            ->notEmpty('email', helper::encode('メールアドレスを入力してください。'))
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return TableRegistry::get('Owners')->exists(['email' => $value]);
                    },
                    'message' => helper::encode('そのメールアドレスは登録されてません。')
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
    public function validationOwnerPassReset2(Validator $validator)
    {
        $validator
            ->scalar('password')
            ->maxLength('password', 32, helper::encode('パスワードが長すぎます。'))
            ->minLength('password', 8, helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password', helper::encode('パスワードを入力してください。'))
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
    public function validationOwnerPassReset3(Validator $validator)
    {
        $validator
            ->scalar('password')
            ->maxLength('password', 32, helper::encode('パスワードが長すぎます。'))
            ->minLength('password', 8, helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password', helper::encode('パスワードを入力してください。'))
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->scalar('password_new')
            ->maxLength('password_new', 32, helper::encode('パスワードが長すぎます。'))
            ->minLength('password_new', 8, helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password_new', helper::encode('パスワードを入力してください。'))
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
