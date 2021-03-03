<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

print $this->element('menu');
?>
<div class="users index large-10 medium-8 columns content">
    <h3><?php print __('Список пользователей') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?php print $this->Paginator->sort('id') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('email') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('name') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('created') ?></th>
                <th scope="col"><?php print $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?php print __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php print $this->Number->format($user->id) ?></td>
                <td><?php print h($user->email) ?></td>
                <td><?php print h($user->name) ?></td>
                <td><?php print h($user->created) ?></td>
                <td><?php print h($user->modified) ?></td>
                <td class="actions">
                    <?php print $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?php print $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?php print $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
