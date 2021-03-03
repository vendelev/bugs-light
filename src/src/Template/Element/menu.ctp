<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php print __('Меню') ?></li>
        <li><?php print $this->Html->link(__('Список задач'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?php print $this->Html->link(__('>> Добавить задачу'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?php print $this->Html->link(__('Список пользователей'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?php print $this->Html->link(__('>> Добавить пользователя'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
<!--        <li>--><?php //print $this->Html->link(__('List Task Types'), ['controller' => 'TaskTypes', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Type'), ['controller' => 'TaskTypes', 'action' => 'add']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('List Task Statuses'), ['controller' => 'TaskStatuses', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Status'), ['controller' => 'TaskStatuses', 'action' => 'add']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('List Task Comments'), ['controller' => 'TaskComments', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Comment'), ['controller' => 'TaskComments', 'action' => 'add']) ?><!-- </li>-->
    </ul>
</nav>
