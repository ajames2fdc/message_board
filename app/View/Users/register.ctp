<!-- app/View/Users/register.ctp -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Register</h2>
                </div>
                <div class="card-body">
                    <?php
                    echo $this->Form->create('User', ['class' => 'form']);
                    echo $this->Form->input('user_name', ['class' => 'form-control', 'label' => 'Username']);
                    echo $this->Form->input('email', ['class' => 'form-control', 'label' => 'Email']);
                    echo $this->Form->input('password', ['class' => 'form-control', 'label' => 'Password']);
                    echo $this->Form->input('password_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => 'Confirm Password']);
                    echo $this->Form->button('Register', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>