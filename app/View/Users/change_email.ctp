<!-- app/View/Users/register.ctp -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Change Password</h2>
                </div>
                <div class="card-body">
                    <?php
                    echo $this->Form->create('User', ['class' => 'form']);
                    echo $this->Form->input('old_email', ['type' => 'password', 'class' => 'form-control ', 'label' => 'Old Email']);
                    echo $this->Flash->render('invalid_email');
                    echo $this->Form->input('new_email', ['type' => 'password', 'class' => 'form-control', 'label' => 'New Email']);
                    echo $this->Form->input('email_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => 'Confirm Email']);
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