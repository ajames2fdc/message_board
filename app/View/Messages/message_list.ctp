<!-- app/View/Messages/message_list.ctp -->
<?php


?>
<div class="container mt-4">
    <div class="row">
        <?php if (!empty($userData)) : ?>
            <div class="col-md-3">
                <div class="list-group">
                    <?php foreach ($userData as $user) : ?>
                        <a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'messageList', $user['User']['user_id'])); ?>" class="list-group-item list-group-item-action">
                            <img src="<?php echo $user['UserProfile']['file_path']; ?>" alt="<?php echo $user['UserProfile']['alt']; ?>" class="rounded-circle mr-2" width="30" />
                            <?php echo $user['UserProfile']['full_name']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'conversation', $selectedUserData['User']['user_id'])); ?>">
                            Messages with <?php echo $selectedUserData['UserProfile']['full_name']; ?>
                            <span class="badge badge-secondary badge-pill">
                                <?php echo count($messagesData); ?>
                            </span>
                        </a>
                        <span class="badge badge-primary badge-pill delete-data float-right" userId="<?php echo $setId; ?>" style="cursor: pointer;">
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
        <?php else : ?>
            <div class="card">
                <div class="card-header">
                    No Messages Found
                </div>
                <div class="card-body">
                    <p>No messages available.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".delete-data").click(function() {
            var receiverId = $(this).attr("userId");

            $.ajax({
                url: 'http://localhost/message-board/messages/deleteMessages',
                type: 'POST',
                dataType: 'json',
                data: {
                    receiverId
                },
                success: function(response) {
                    $(".card").fadeOut(3000, function() {
                        $(this).remove();

                        location.reload();
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            })
        })
    })
</script>