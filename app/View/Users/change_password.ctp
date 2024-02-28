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
                    echo $this->Form->input('old_password', ['type' => 'password', 'class' => 'form-control ', 'label' => 'Password']);
                    echo $this->Flash->render('invalid_password');
                    echo $this->Form->input('new_password', ['type' => 'password', 'class' => 'form-control', 'label' => 'Confirm Password']);
                    echo $this->Form->input('password_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => 'Confirm Password']);
                    echo $this->Flash->render('invalid_match');
                    echo $this->Form->button('Submit', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Flash->render('success');
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>