<!-- app/View/Messages/message_list.ctp -->
<?php
// echo debug($messagesData)

?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <?php foreach ($userData as $user) : ?>
                    <a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'conversation', $user['User']['user_id'])); ?>" class="list-group-item list-group-item-action">
                        <img src="<?php echo $user['UserProfile']['file_path']; ?>" alt="<?php echo $user['UserProfile']['alt']; ?>" class="rounded-circle mr-2" width="30" />
                        <?php echo $user['UserProfile']['full_name']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Messages with <?php echo $userData[0]['UserProfile']['full_name']; ?>
                    <span class="badge badge-secondary badge-pill float-right">
                        <?php echo count($messagesData); ?>
                    </span>
                    <span class="badge badge-primary badge-pill delete-data" style="cursor: pointer;" onclick="deleteData(<?php echo $user['User']['user_id']; ?>)">
                        <i class="fas fa-trash-alt"></i> Delete
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($messagesData as $message) : ?>
                            <li class="list-group-item">
                                <?php echo $message['Message']['content']; ?>
                                <span class="badge badge-secondary badge-pill float-right"><?php echo $message['Message']['created_at']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <!-- Your message input form goes here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".delete-data").click(function() {
            $.ajax({
                url: 'messages/deleteMessages',
                type: 'POST',
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    // Handle errors
                    console.error("Error occurred:", error);
                }
            })
        })
    })
</script>