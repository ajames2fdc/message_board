<!-- app/View/Users/welcome_view.ctp -->
<?php $this->assign('title_for_layout', 'Welcome to the Message Board'); ?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Congratulations!</h4>
                <p>Your account has been successfully registered. Welcome to our community!</p>
                <hr>
                <p class="mb-0">Thank you for joining us.</p>
            </div>

            <!-- Add a link to the login screen -->
            <p class="mt-3">Already have an account? <?= $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')) ?></p>
        </div>
    </div>
</div>