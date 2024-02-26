<?php
// echo debug($profileData);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>User Profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="Name">Name:</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['first_name'] . ' ' . $profileData['UserProfile']['last_name']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="email">Gender:</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['gender']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Birthday:</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['birthday']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Hobby:</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['hobby']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Bio:</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['bio']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Profile Picture</label>
                        <p class="form-control-static"><?php echo h($profileData['UserProfile']['profile_picture']); ?></p>
                    </div>
                    <!-- Add more profile fields as needed -->

                    <div class="text-center mt-3">
                        <?php echo $this->Html->link('Edit Profile', array('controller' => 'userProfiles', 'action' => 'edit', $profileData['UserProfile']['user_id']), array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>