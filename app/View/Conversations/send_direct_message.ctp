<!-- app/View/Conversations/send_direct_message.ctp -->

<div class="container mt-5">
    <h2>Send Direct Message</h2>

    <?php echo $this->Form->create('Conversation', ['url' => ['controller' => 'conversations', 'action' => 'sendDirectMessage', $recipientId]]); ?>

    <?php
    echo $this->Form->hidden('recipient_id', ['value' => $recipientId]);
    echo $this->Form->textarea('message_content', ['class' => 'form-control', 'rows' => '3', 'label' => 'Message']);
    echo $this->Form->button('Send Message', ['class' => 'btn btn-primary btn-block mt-3']);
    ?>

    <?php echo $this->Form->end(); ?>
</div>