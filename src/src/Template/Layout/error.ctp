<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php print $this->Html->charset() ?>
    <title>
        <?php print $this->fetch('title') ?>
    </title>
    <?php print $this->Html->meta('icon') ?>

    <?php print $this->Html->css('base.css') ?>
    <?php print $this->Html->css('style.css') ?>

    <?php print $this->fetch('meta') ?>
    <?php print $this->fetch('css') ?>
    <?php print $this->fetch('script') ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1><?php print __('Error') ?></h1>
        </div>
        <div id="content">
            <?php print $this->Flash->render() ?>

            <?php print $this->fetch('content') ?>
        </div>
        <div id="footer">
            <?php print $this->Html->link(__('Back'), 'javascript:history.back()') ?>
        </div>
    </div>
</body>
</html>
