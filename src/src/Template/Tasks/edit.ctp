<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */

print $this->element('menu');
?>
<div class="tasks form large-9 medium-8 columns content">
    <?php print $this->Form->create($task) ?>
    <fieldset>
        <legend><?php print __('Редактировать') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('owner_id', ['options' => $users]);
            echo $this->Form->control('worker_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('type_id', ['options' => $taskTypes]);
            echo $this->Form->control('status_id', ['options' => $taskStatuses]);
        ?>
    </fieldset>
    <?php print $this->Form->button(__('Сохранить')) ?>
    <?php print $this->Form->end() ?>
</div>
