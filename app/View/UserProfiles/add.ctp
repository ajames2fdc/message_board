<!-- app/View/UserProfiles/add.ctp -->
<?php
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Create User Profile</h2>
                </div>
                <div class="card-body">
                    <div class="profile-picture-frame">
                        <img class="profile-picture" id="profilePicturePreview" src="#" alt="">
                    </div>
                    <?php
                    echo $this->Form->create('UserProfile', ['class' => 'form', 'enctype' => 'multipart/form-data'],);
                    echo $this->Form->input('first_name', ['label' => 'First Name', 'class' => 'form-control']);
                    echo $this->Form->input('last_name', ['label' => 'Last Name', 'class' => 'form-control']);
                    echo $this->Form->input('gender', ['label' => 'Gender', 'class' => 'form-control', 'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']]); ?>
                    <div class=" form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" name="birthday" class="datepicker form-control">
                    </div>
                    <?php
                    echo $this->Form->input('hobby', ['label' => 'Hobby', 'class' => 'form-control']);
                    echo $this->Form->input('bio', ['label' => 'Bio', 'class' => 'form-control', 'rows' => '3']);
                    echo $this->Form->input('profile_picture', [
                        'type' => 'file',
                        'label' => 'Profile Picture',
                        'class' => 'form-control-file',
                        'id' => 'profilePictureInput',
                        'required' => 'false'
                    ]);

                    echo $this->Form->button('Save', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Flash->render('success');
                    echo $this->Flash->render('error');
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
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
    })
</script>