<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Chat</h2>
                </div>
                <div class="card-body">
                    <div class="chat-box">
                        <?php foreach ($messagesData as $message) : ?>
                            <h1><?php echo $message['Message']['content'] ?></h1>
                        <?php endforeach; ?>
                    </div>
                    <form method="post" action="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'newMessage')); ?>">
                        <div class="form-group">
                            <textarea name="content" class="form-control" placeholder="Type your message"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>