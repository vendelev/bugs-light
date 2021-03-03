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

$cakeDescription = 'CakePHP: the rapid development php framework';
$this->assign('title', __('Баг треккер лайт'));
?>
<!DOCTYPE html>
<html>
<head>
    <?php print $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php print $cakeDescription ?>:
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
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-2 medium-4 columns">
            <li class="name">
                <h1><a href="/"><?php print $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <?php
                if ($isAuth) { ?>
                <li><a href="<?php print $this->Url->build(['controller' => 'users', 'action' => 'logout']); ?>"
                    ><?php print __('Выход'); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <?php print $this->Flash->render() ?>
    <div class="container clearfix">
        <?php print $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
