<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Casts Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\CastLikesTable&\Cake\ORM\Association\HasMany $CastLikes
 * @property \App\Model\Table\CastSchedulesTable&\Cake\ORM\Association\HasMany $CastSchedules
 * @property \App\Model\Table\DiarysTable&\Cake\ORM\Association\HasMany $Diarys
 * @property \App\Model\Table\SnssTable&\Cake\ORM\Association\HasMany $Snss
 * @property \App\Model\Table\UpdatesTable&\Cake\ORM\Association\HasMany $Updates
 *
 * @method \App\Model\Entity\Cast get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cast newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cast[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cast|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cast saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cast patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cast[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cast findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CastsTable extends Table
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

        $this->setTable('casts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CastLikes', [
            'foreignKey' => 'cast_id',
        ]);
        $this->hasMany('CastSchedules', [
            'foreignKey' => 'cast_id',
        ]);
        $this->hasMany('Diarys', [
            'foreignKey' => 'cast_id',
        ]);
        $this->hasMany('Snss', [
            'foreignKey' => 'cast_id',
        ]);
        $this->hasMany('Updates', [
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
            ->scalar('role')
            ->notEmpty('name', helper::encode('名前を入力してください。'))
            ->maxLength('name', 30, helper::encode('名前が長すぎます。'))
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('nickname')
            ->notEmpty('nickname', helper::encode('ニックネームを入力してください。'))
            ->maxLength('nickname', 30, helper::encode('ニックネームが長すぎます。'))
            ->requirePresence('nickname', 'create')
            ->notEmptyString('nickname');

        $validator
            ->email('email',false, helper::encode('メールアドレスの形式が不正です。'))
            ->notEmpty('email', helper::encode('メールアドレスを入力してください。'))
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        // ユニークキーとメールアドレスで存在チェックし、変更がない場合は、チェックしない
                        if (TableRegistry::get('casts')->exists(['id' => $context['data']['id'], 'email' => $value])) {
                            return true;
                        } else if (TableRegistry::get('casts')->exists(['email' => $value])) {
                           $count = TableRegistry::get('casts')->exists(['email' => $value]);
                        // 上記以外はアドレスに変更があったとみなし、アドレスの重複チェックを判定する
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message' => helper::encode('そのメールアドレスは既に登録されています。')
                ],
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255,helper::encode('パスワードが長すぎます。'))
            ->minLength('password', 8,helper::encode('パスワードが短すぎます。'))
            ->notEmpty('password', helper::encode('パスワードを入力してください。'))
            ->requirePresence('password', 'create')
            ->allowEmptyString('password');

        $validator
            ->dateTime('birthday')
            ->allowEmptyDateTime('birthday');

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
            ->maxLength('message', 50, helper::encode('メッセージが長すぎます。'))
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
     * バリデーション ログイン.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationCastLogin(Validator $validator)
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
     * バリデーション プロフィール変更用.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationProfile(Validator $validator)
{
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
            ->scalar('nickname')
            ->notEmpty('nickname', helper::encode('ニックネームを入力してください。'))
            ->maxLength('nickname', 30, helper::encode('ニックネームが長すぎます。'))
            ->requirePresence('nickname', 'create')
            ->allowEmptyString('nickname', false);

        $validator
            ->date('birthday')
            ->allowEmptyTime('birthday');

        $validator
            ->scalar('age')
            ->maxLength('age', 5)
            ->allowEmptyString('age');

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
    public function validationCastPassReset1(Validator $validator)
    {
        $validator
            ->email('email',false, helper::encode('メールアドレスの形式が不正です。'))
            ->notEmpty('email', helper::encode('メールアドレスを入力してください。'))
            ->add('email', [
                'exists' => [
                    'rule' => function($value, $context) {
                        return TableRegistry::get('casts')->exists(['email' => $value]);
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
    public function validationCastPassReset2(Validator $validator)
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
    public function validationCastPassReset3(Validator $validator)
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
        $rules->add($rules->existsIn(['shop_id'], 'Shops'));

        return $rules;
    }
}
