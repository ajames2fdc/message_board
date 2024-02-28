<!-- app/View/Messages/message_list.ctp -->
<?php
?>

<div class="container mt-5">
    <h2>Message List</h2>
    <ul class="list-group">
        <?php foreach ($messagesData as $message) : ?>
            <li class="list-group-item">
                <strong>From:</strong> <?php echo $this->Html->link($message['SenderProfile']['full_name'], array('controller' => 'messages', 'action' => 'conversation', $userId)) ?>
                <br>
                <strong>To:</strong> <?= h($message['ReceiverProfile']['full_name']) ?>
                <br>
                <!-- <strong>Message:</strong> <?= h($message['Message']['content']) ?> -->
            </li>
        <?php endforeach; ?>
    </ul>
</div>