<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

print $this->element('menu');
?>
<div class="users view large-10 medium-8 columns content">
    <h3><?php print h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?php print __('Id') ?></th>
            <td><?php print $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Email') ?></th>
            <td><?php print h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Name') ?></th>
            <td><?php print h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Created') ?></th>
            <td><?php print h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php print __('Modified') ?></th>
            <td><?php print h($user->modified) ?></td>
        </tr>
    </table>
</div>
