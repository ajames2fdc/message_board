<!-- app/View/Conversations/new_message.ctp -->

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
                    echo $this->Form->input('recipient_id', ['class' => 'form-control select2', 'label' => 'Recipient']);
                    echo $this->Form->textarea('content', ['class' => 'form-control', 'label' => 'Message']);
                    echo $this->Form->button('Send Message', ['class' => 'btn btn-primary btn-block mt-3']);
                    echo $this->Form->end();
                    ?>

                    <!-- Include Select2 initialization script -->
                    <script>
                        $(document).ready(function() {
                            $('#MessageRecipientId').select2({

                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>