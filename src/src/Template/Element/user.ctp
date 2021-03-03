<?php

if ($user->deleted) {
    print h($user->name);
} else {
    print $this->Html->link(
        $user->name,
        ['controller' => 'Users', 'action' => 'view', $user->id]
    );
}
