<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task[]|\Cake\Collection\CollectionInterface $tasks
 * @var \App\Model\Entity\User $currentUser
 */

print $this->element('menu');
?>
<div class="tasks index large-10 medium-8 columns content">
    <h3><?php print __('Список задач') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?php print __('Task') ?></th>
                <th scope="col" style="width:250px"><?php print $this->Paginator->sort('owner_id') ?></th>
                <th scope="col" style="width:250px"><?php print $this->Paginator->sort('worker_id') ?></th>
                <th scope="col" style="width:210px"><?php print $this->Paginator->sort('type_id') ?></th>
                <th scope="col" style="width:100px"><?php print $this->Paginator->sort('status_id') ?></th>
                <th scope="col" style="width:150px"><?php print $this->Paginator->sort('created') ?></th>
                <th scope="col" style="width:150px"><?php print $this->Paginator->sort('modified') ?></th>
                <th scope="col" style="width:100px" class="actions"><?php print __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php
                    print $this->Number->format($task->id) .'. ';
                    print $this->Html->link($this->Text->truncate($task->title, 40), ['action' => 'view', $task->id]);
                    ?></td>
                <td><?php print $task->has('owner') ? $this->element('user', ['user' => $task->owner]) : '' ?></td>
                <td><?php print $task->has('worker') ? $this->element('user', ['user' => $task->worker]) : '' ?></td>
                <td><?php print $task->has('task_type') ? h($task->task_type->title) : '' ?></td>
                <td><?php print $task->has('task_status') ? h($task->task_status->title) : '' ?></td>
                <td><?php print h($task->created) ?></td>
                <td><?php print h($task->modified) ?></td>
                <td class="actions">
                    <?php
                    if ($task->owner->id === $currentUser['id'] || ($task->worker && $task->worker->id === $currentUser['id'])) {
                        print $this->Html->link(__('Edit'), ['action' => 'edit', $task->id]);
                    }
                    if ($task->owner->id === $currentUser['id']) {
                        print '&nbsp;';
                        print $this->Form->postLink(__('Delete'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]);
                    }
                    ?>
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
