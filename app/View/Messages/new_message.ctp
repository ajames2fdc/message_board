<!-- app/View/Messages/new_message.ctp -->
<?php
// echo debug($userProfiles);
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">New Message</h2>
                </div>
                <div class="card-body">
                    <?php
                    echo $this->Form->create('Message', ['class' => 'form']);
                    echo $this->Form->input('receiver_id', [
                        'class' => 'form-control select2',
                        'label' => 'Recipient',
                        'empty' => 'Select recipient',
                        'options' => $userProfiles
                    ]);
                    echo $this->Form->textarea('content', ['class' => 'form-control', 'label' => 'Message']);
                    echo $this->Form->button('Send Message', ['class' => 'btn btn-primary submit-button btn-block mt-3']);
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>