<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * ShopLikes Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ShopLike get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShopLike newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShopLike[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShopLike|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShopLike saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShopLike patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShopLike[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShopLike findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopLikesTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('shop_likes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Shops', [
            'foreignKey' => 'shop_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['shop_id'], 'Shops'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    // テーブルまたはビヘイビアークラスの中で
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['shop_likes_id'])) {
            $data['id'] = $data['shop_likes_id'];
        }
        if (isset($data['shop_likes_shop_id'])) {
            $data['shop_id'] = $data['shop_likes_shop_id'];
        }
        if (isset($data['shop_likes_user_id'])) {
            $data['user_id'] = $data['shop_likes_user_id'];
        }
        if (isset($data['shop_likes_created'])) {
            $data['created'] = $data['shop_likes_created'];
        }
    }
}
