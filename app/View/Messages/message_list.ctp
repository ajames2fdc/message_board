<!-- app/View/Messages/message_list.ctp -->
<?php
?>

<div class="container mt-5">
    <h2>Message List</h2>
    <ul class="list-group">
        <?php foreach ($messagesData as $message) : ?>
            <li class="list-group-item">
                <strong>From:</strong> <?= h($message['SenderProfile']['full_name']) ?>
                <br>
                <strong>To:</strong> <?= h($message['ReceiverProfile']['full_name']) ?>
                <br>
                <!-- <strong>Message:</strong> <?= h($message['Message']['content']) ?> -->
            </li>
        <?php endforeach; ?>
    </ul>
</div>