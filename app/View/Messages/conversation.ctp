<?php
echo debug($receiverData);
?>

<div class="container mt-4">
    <div class="card bg-dark text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="user-info" recieverId="<?php echo $receiverData['Receiver']['user_id']; ?>">
                <a href="<?php echo $this->Html->url(array('controller' => 'userProfiles', 'action' => 'view', $receiverData['Receiver']['user_id'])); ?>">
                    <img src="<?php echo $receiverData['Receiver']['file_path'] ?>" alt="<?php $receiverData['Receiver']['alt'] ?>" class="user-avatar" />
                    <span><?php echo $receiverData['Receiver']['full_name']; ?></span>
                </a>
            </div>
        </div>
        <div class="conversations">
            <div class="chat-container">
                <?php foreach ($messagesData as $message) : ?>
                    <div class="message <?php echo $message['Message']['sender_id'] == $userId ? 'user-message' : ''; ?>">
                        <img src="<?php echo $message['Message']['sender_id'] == $userId ? $senderData['Sender']['file_path'] : $receiverData['Receiver']['file_path']; ?>" alt="<?php echo $message['Message']['sender_id'] == $userId ? $senderData['Sender']['alt'] : $receiverData['Receiver']['alt']; ?>" class="user-avatar" />
                        <div class="message-content">
                            <?php echo $message['Message']['content']; ?>
                            <div class="message-details">
                                <span class="mr-2"><?php echo $message['Message']['sender_id'] == $userId ? $senderData['Sender']['full_name'] : $receiverData['Receiver']['full_name']; ?></span>
                                <span><?php echo $message['Message']['created_at']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <?php
                echo $this->Form->create('Message', ['class' => 'form', 'id' => 'replyForm']);
                echo $this->Form->textarea('content', ['class' => 'form-control', 'label' => 'Message']);
                echo $this->Form->button('Send Message', ['class' => 'btn btn-primary submit-button btn-block mt-3']);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>