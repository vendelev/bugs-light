<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

print $this->element('menu');
?>
<div class="users form large-10 medium-8 columns content">
    <?php print $this->Form->create($user) ?>
    <fieldset>
        <legend><?php print __('Add User') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('pass');
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?php print $this->Form->button(__('Submit')) ?>
    <?php print $this->Form->end() ?>
</div>
