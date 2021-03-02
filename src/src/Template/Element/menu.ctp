<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?php print __('Actions') ?></li>
        <li><?php print $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?php print $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?php print $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?php print $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
<!--        <li>--><?php //print $this->Html->link(__('List Task Types'), ['controller' => 'TaskTypes', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Type'), ['controller' => 'TaskTypes', 'action' => 'add']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('List Task Statuses'), ['controller' => 'TaskStatuses', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Status'), ['controller' => 'TaskStatuses', 'action' => 'add']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('List Task Comments'), ['controller' => 'TaskComments', 'action' => 'index']) ?><!-- </li>-->
<!--        <li>--><?php //print $this->Html->link(__('New Task Comment'), ['controller' => 'TaskComments', 'action' => 'add']) ?><!-- </li>-->
    </ul>
</nav>
