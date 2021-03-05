<?php
namespace App\Model\Table;

use App\Model\Entity\TaskType;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * TaskTypes Model
 *
 * @method TaskType get($primaryKey, $options = [])
 * @method TaskType newEntity($data = null, array $options = [])
 * @method TaskType[] newEntities(array $data, array $options = [])
 * @method TaskType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method TaskType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method TaskType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method TaskType[] patchEntities($entities, array $data, array $options = [])
 * @method TaskType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TaskTypesTable extends Table
{
    use SoftDeleteTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('task_types');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }
}
