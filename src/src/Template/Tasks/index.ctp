<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task[]|\Cake\Collection\CollectionInterface $tasks
 */

print $this->element('menu');
?>
<div class="tasks index large-9 medium-8 columns content">
    <h3><?php print __('Список задач') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?php print $this->Paginator->sort('id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('owner_id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('worker_id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('type_id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('status_id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('created') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?php print __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php print $this->Number->format($task->id) ?></td>
                <td><?php
                    $value = '';
                    if ($task->has('owner')) {
                        if ($task->owner->deleted) {
                            $value = h($task->owner->name);
                        } else {
                            $value = $this->Html->link(
                                    $task->owner->name,
                                    ['controller' => 'Users', 'action' => 'view', $task->owner->id]
                            );
                        }
                    }

                    print $value;
                    ?></td>
                <td><?php
                    $value = '';
                    if ($task->has('worker')) {
                        if ($task->worker->deleted) {
                            $value = h($task->worker->name);
                        } else {
                            $value = $this->Html->link(
                                    $task->worker->name,
                                    ['controller' => 'Users', 'action' => 'view', $task->worker->id]
                            );
                        }
                    }

                    print $value;
                    ?></td>
                <td><?php print $task->has('task_type') ? h($task->task_type->title) : '' ?></td>
                <td><?php print $task->has('task_status') ? h($task->task_status->title) : '' ?></td>
                <td><?php print $this->Time->nice($task->created, null, 'ru'); ?></td>
                <td><?php print $this->Time->nice($task->modified, null, 'ru') ?></td>
                <td class="actions">
                    <?php print $this->Html->link(__('View'), ['action' => 'view', $task->id]) ?>
                    <?php print $this->Html->link(__('Edit'), ['action' => 'edit', $task->id]) ?>
                    <?php print $this->Form->postLink(__('Delete'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php print $this->Paginator->first('<< ' . __('first')) ?>
            <?php print $this->Paginator->prev('< ' . __('previous')) ?>
            <?php print $this->Paginator->numbers() ?>
            <?php print $this->Paginator->next(__('next') . ' >') ?>
            <?php print $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?php print $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
