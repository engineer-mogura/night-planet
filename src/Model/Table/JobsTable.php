<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Event\Event;
use App\Helper\helper;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Jobs Model
 *
 * @property \App\Model\Table\ShopsTable&\Cake\ORM\Association\BelongsTo $Shops
 *
 * @method \App\Model\Entity\Job get($primaryKey, $options = [])
 * @method \App\Model\Entity\Job newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Job[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Job|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Job saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Job patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Job[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Job findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JobsTable extends Table
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

        $this->setTable('jobs');
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
        $validator->setProvider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('industry')
            ->maxLength('industry', 30)
            ->allowEmptyString('industry');

        $validator
            ->scalar('job_type')
            ->maxLength('job_type', 30)
            ->allowEmptyString('job_type');

        $validator
            ->time('work_from_time')
            ->allowEmptyTime('work_from_time');

        $validator
            ->time('work_to_time')
            ->allowEmptyTime('work_to_time');

        $validator
            ->scalar('work_time_hosoku')
            ->maxLength('work_time_hosoku', 50, helper::encode('���Ԃɂ��Ă̕⑫��50�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('work_time_hosoku');

        $validator
            ->scalar('from_age')
            ->maxLength('from_age', 2)
            ->allowEmptyString('from_age')
            ->allowEmpty('from_age', function ($context) {
                $from_age = $context['data']['from_age'];
                $to_age = $context['data']['to_age'];
                if (!empty($to_age) && empty($from_age)) {
                    return false;
                }
                return true;
            }, [helper::encode('���̔N�����͂���ۂ́A��̔N������͂��ĉ�����')]);

        $validator
            ->scalar('to_age')
            ->maxLength('to_age', 2)
            ->allowEmptyString('to_age')
            ->allowEmpty('to_age', function ($context) {
                $to_age = $context['data']['to_age'];
                $from_age = $context['data']['from_age'];
                if (!empty($from_age) && empty($to_age)) {
                    return false;
                }
                return true;
            }, [helper::encode('��̔N�����͂���ۂ́A���̔N������͂��ĉ�����')])
            ->greaterThanField('to_age', 'from_age', helper::encode('�N��͈̔͂��s���ł��B'));

        $validator
            ->scalar('qualification_hosoku')
            ->maxLength('qualification_hosoku', 50, helper::encode('���i�ɂ��Ă̕⑫��50�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('qualification_hosoku');

        $validator
            ->scalar('holiday')
            ->maxLength('holiday', 50)
            ->allowEmptyString('holiday');

        $validator
            ->scalar('holiday_hosoku')
            ->maxLength('holiday_hosoku', 50, helper::encode('�x���ɂ��Ă̕⑫��50�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('holiday_hosoku');

        $validator
            ->scalar('treatment')
            ->maxLength('treatment', 255)
            ->allowEmptyString('treatment');

        $validator
            ->scalar('pr')
            ->maxLength('pr', 400, helper::encode('PR����400�����ȓ��ɂ��Ă��������B'))
            ->allowEmptyString('pr');

        $validator
            ->scalar('tel1')
            ->maxLength('tel1', 15, helper::encode('�d�b�ԍ��P�͒����ł��B'))
            ->allowEmptyString('tel1')
            ////�d�b�ԍ��`���̃`�F�b�N ////
            ->add('tel1', 'tel_check', [
                'rule' =>'tel_check',
                'provider' => 'custom',
                'message' => helper::encode('�d�b�ԍ��P�͖����ȓd�b�ԍ��ł��B')
            ]);

        $validator
            ->scalar('tel2')
            ->maxLength('tel2', 15, helper::encode('�d�b�ԍ��Q�͒����ł��B'))
            ->allowEmptyString('tel2')
            ////�d�b�ԍ��`���̃`�F�b�N ////
            ->add('tel2', 'tel_check', [
                'rule' =>'tel_check',
                'provider' => 'custom',
                'message' => helper::encode('�d�b�ԍ��Q�͖����ȓd�b�ԍ��ł��B')
            ]);

        $validator
            ->email('email', false, helper::encode('���[���A�h���X�̌`�����s���ł��B'))
            ->allowEmptyString('email');

        $validator
            ->scalar('lineid')
            ->maxLength('lineid', 20, helper::encode('�d�b�ԍ��P�͒����ł��B'))
            ->allowEmptyString('lineid');

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

    /**
     * ���N�G�X�g�f�[�^���G���e�B�e�B�[�ɕϊ������O�ɌĂ΂�鏈���B
     * ��Ƀ��N�G�X�g�f�[�^�ɕϊ����|������A�o���f�[�V��������������Ŏ��O�ɉ���������ł���B
     * @param Event $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        // �x���́Acsv�`���ɕϊ�
        if (isset($data['holiday'])) {
            $data['holiday'] = implode(',', $data['holiday']);
        }
        // tel1�́A�n�C�t���폜
        if (isset($data['tel1'])) {
            $data['tel1'] = str_replace(array('-', '?', '�]'), '', $data['tel1']);
        }
        // tel2�́A�n�C�t���폜
        if (isset($data['tel2'])) {
            $data['tel2'] = str_replace(array('-', '?', '�]'), '', $data['tel2']);
        }

        // email�́A�󕶎��̏ꍇ��null��Ԃ��B�d���G���[��h��
        $data['email'] = $data['email'] !== '' ? $data['email'] : null;
        if (is_null($data['email'])) {
            return;
        }
        $conditions = array('id' => $data['job_edit_id'],'email' => $data['email']);
        $this->Jobs = TableRegistry::get('Jobs');
        // ���[���A�h���X���o�^���Ă�����e�ƈ�v�����ꍇ�ɂ́A�d���`�F�b�N�G���[����������B
        if ($this->Jobs->find()->where($conditions)->count()) {
            $this->Jobs->validator('default')->offsetUnset('email');
        };
    }
}
