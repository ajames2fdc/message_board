<?php
$currentAction = $this->request->params['action'];
$isYourAction = $currentAction === 'add';

// Add a class to the link based on the current action
$linkClass = $isYourAction ? 'disabled' : '';
?>

<!-- app/View/Elements/navbar.ctp -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand"><?= $this->Html->link('Message Board', array('controller' => 'home', 'action' => 'index'), array('class' => $linkClass)) ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if ($loggedIn) : ?>
                <li class="nav-item ml-5">
                    <span class="navbar-text">
                        Welcome, <?php echo $this->Html->link($userName, array('controller' => 'userProfiles', 'action' => 'view', $userId), array('class' => $linkClass)) ?>

                    </span>
                </li>
                <li class="nav-item ml-5">
                    <span class="navbar-text">
                        <?php echo $this->Html->link('Change Password', array('controller' => 'users', 'action' => 'changePassword', $userId), array('class' => $linkClass)) ?>
                    </span>
                </li>
                <li class="nav-item ml-2">
                    <?= $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'nav-link')) ?>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <?= $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link')) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>