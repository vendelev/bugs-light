<?php
namespace App\Model\Table;

use App\Model\Entity\TaskStatus;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * TaskStatuses Model
 *
 * @method TaskStatus get($primaryKey, $options = [])
 * @method TaskStatus newEntity($data = null, array $options = [])
 * @method TaskStatus[] newEntities(array $data, array $options = [])
 * @method TaskStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method TaskStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method TaskStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method TaskStatus[] patchEntities($entities, array $data, array $options = [])
 * @method TaskStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TaskStatusesTable extends Table
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

        $this->setTable('task_statuses');
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
