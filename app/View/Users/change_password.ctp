<!-- app/View/Users/change_password.ctp -->

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
                    echo $this->Form->input('old_password', ['type' => 'password', 'class' => 'form-control', 'label' => 'Current Password']);
                    echo $this->Form->input('new_password', ['type' => 'password', 'class' => 'form-control', 'label' => 'New Password']);
                    echo $this->Form->input('password_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => 'Confirm Password']);
                    echo $this->Form->button('Register', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#user_name').disabled = true;
    })
</script>