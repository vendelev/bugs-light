<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $owner_id
 * @property int|null $worker_id
 * @property int $type_id
 * @property int $status_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\User $owner
 * @property \App\Model\Entity\User $worker
 * @property \App\Model\Entity\TaskType $task_type
 * @property \App\Model\Entity\TaskStatus $task_status
 * @property \App\Model\Entity\TaskComment[] $task_comments
 */
class Task extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'owner_id' => true,
        'worker_id' => true,
        'type_id' => true,
        'status_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'owner' => true,
        'worker' => true,
        'task_type' => true,
        'task_status' => true,
        'task_comments' => true,
    ];
}
