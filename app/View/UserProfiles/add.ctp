<!-- app/View/UserProfiles/add.ctp -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Create User Profile</h2>
                </div>
                <div class="card-body">
                    <?php
                    echo $this->Form->create('UserProfile', ['class' => 'form', 'enctype' => 'multipart/form-data'],);
                    echo $this->Form->input('first_name', ['label' => 'First Name', 'class' => 'form-control']);
                    echo $this->Form->input('last_name', ['label' => 'Last Name', 'class' => 'form-control']);
                    echo $this->Form->input('gender', ['label' => 'Gender', 'class' => 'form-control', 'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']]); ?>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" name="birthday" class="datepicker form-control">
                    </div>
                    <?php
                    echo $this->Form->input('hobby', ['label' => 'Hobby', 'class' => 'form-control']);
                    echo $this->Form->input('bio', ['label' => 'Bio', 'class' => 'form-control', 'rows' => '3']);
                    echo $this->Form->input('profile_picture', ['type' => 'file', 'label' => 'Profile Picture', 'class' => 'form-control-file']);

                    echo $this->Form->button('Save', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Initialize the datepicker
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd', // Set the desired date format
            defaultDate: today,
            maxDate: today,
            yearRange: '-100:+0', // Allow selection of the last 100 years
        });
    });
</script>