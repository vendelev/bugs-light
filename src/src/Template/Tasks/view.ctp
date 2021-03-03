<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */

print $this->element('menu');
?>

<div class="tasks view large-10 medium-8 columns content">
    <h3>#<?php print $task->id .' '. h($task->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php print __('Автор') ?></th>
            <td><?php print $task->has('owner') ? $this->element('user', ['user' => $task->owner]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Исполнитель') ?></th>
            <td><?php print $task->has('worker') ? $this->element('user', ['user' => $task->worker]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Тип задачи') ?></th>
            <td><?php print $task->has('task_type') ? h($task->task_type->title) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Статус') ?></th>
            <td><?php print $task->has('task_status') ? h($task->task_status->title) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Созданно') ?></th>
            <td><?php print $this->Time->nice($task->created); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Обновлено') ?></th>
            <td><?php print $this->Time->nice($task->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?php print __('Описание') ?></h4>
        <?php print $this->Text->autoParagraph(h($task->description)); ?>
    </div>
    <div class="related">
        <h4><?php print __('Комментарии') ?></h4>
        <?php if (!empty($task->task_comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?php print __('Пользователь') ?></th>
                <th scope="col"><?php print __('Сообщение') ?></th>
                <th scope="col"><?php print __('Дата') ?></th>
                <th scope="col" class="actions">&nbsp;</th>
            </tr>
            <?php foreach ($task->task_comments as $taskComments): ?>
            <tr>
                <td><?php print h($taskComments->user->name) ?></td>
                <td><?php print h($taskComments->message) ?></td>
                <td><?php print h($taskComments->created) ?></td>
                <td class="actions">
                    <?php print $this->Html->link(__('Edit'), ['controller' => 'TaskComments', 'action' => 'edit', $taskComments->id]) ?>
                    <?php print $this->Form->postLink(__('Delete'), ['controller' => 'TaskComments', 'action' => 'delete', $taskComments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taskComments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
