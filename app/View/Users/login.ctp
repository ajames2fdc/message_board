<!-- app/View/Users/login.ctp -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Login</h2>
                </div>
                <div class="card-body">
                    <?php
                    echo $this->Form->create('User', ['class' => 'form']);
                    echo $this->Form->input('user_name', ['class' => 'form-control', 'label' => 'Username']);
                    echo $this->Form->input('password', ['class' => 'form-control', 'label' => 'Password']);
                    echo $this->Form->button('Login', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                    <div class="mt-3 text-center">
                        <?php echo $this->Html->link('Forgot Password?', array('controller' => 'users', 'action' => 'forgotPassword')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>