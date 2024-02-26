<!-- app/View/Home/index.ctp -->

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Welcome to the Message Board!</h2>
            <p>
                Join our community to share your thoughts, ask questions, and connect with other users.
            </p>
            <?php
            // Add the "Send Direct Message" button
            echo $this->Html->link(
                'Send Direct Message',
                ['controller' => 'conversations', 'action' => 'newMessage'],
                ['class' => 'btn btn-primary btn-sm ml-2']
            );
            ?>
        </div>
    </div>
</div>