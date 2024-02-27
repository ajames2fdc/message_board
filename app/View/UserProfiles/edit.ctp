<?php
// echo debug($userProfile);
?>

<!-- app/View/Users/edit.ctp -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Edit User Profile</h2>
                </div>
                <div class="card-body">
                    <div class="profile-picture-frame">
                        <img class="profile-picture" id="profilePicturePreview" src="#" alt="">
                    </div>
                    <?php
                    echo $this->Form->create('UserProfile', ['class' => 'form', 'enctype' => 'multipart/form-data']);
                    echo $this->Form->input('first_name', array(
                        'label' => 'First Name',
                        'class' => 'form-control',
                    ));

                    echo $this->Form->input('last_name', array(
                        'label' => 'Last Name',
                        'class' => 'form-control',
                    ));
                    echo $this->Form->input('gender', array(
                        'label' => 'Gender',
                        'class' => 'form-control',
                        'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
                    )); ?>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" name="birthday" class="datepicker form-control" value="<?php echo $userProfile['UserProfile']['birthday']; ?>">
                    </div>
                    <?php
                    echo $this->Form->input('hobby', array(
                        'label' => 'Hobby',
                        'class' => 'form-control',
                    ));
                    echo $this->Form->input('bio', array(
                        'label' => 'Bio',
                        'class' => 'form-control', 'rows' => '3',
                    ));
                    //TODO add file handling
                    echo $this->Form->input('profile_picture', ['type' => 'file', 'label' => 'Profile Picture',]);

                    echo $this->Form->button('Save', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                    <!-- Display the selected image inside a square box -->
                    <?php if (!empty($this->request->data['profile_picture']['name'])) : ?>
                        <div class="square-box">
                            <img src="<?php echo $this->Upload->url('Post.image'); ?>" alt="Uploaded Image" class="square-image">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Initialize the datepicker
        // $('.datepicker').datepicker();
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd', // Set the desired date format
            yearRange: '-100:+0', // Allow selection of the last 100 years
        });
        $("#profilePictureInput").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profilePicturePreview').attr("src", e.target.result);
                    $('#profilePicturePreview').attr("alt", input.files[0].name);
                    $('#profilePicturePreview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>