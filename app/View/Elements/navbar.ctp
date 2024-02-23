<!-- app/View/Elements/navbar.ctp -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Message Board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if ($loggedIn) : ?>
                <li class="nav-item">
                    <span class="navbar-text">
                        Welcome, <?php echo $userName; ?>
                    </span>
                </li>
                <li class="nav-item">
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