<?php
App::uses('Messages', 'Model');

class Messages extends Model
{
    public $validate = array(
        'conversation_id' => array(
            'rule' => 'numeric',
            'message' => 'Please enter a valid conversation ID.'
        ),
        'receiver_id' => array(
            'rule' => 'numeric',
            'message' => 'Please enter a valid receiver ID.'
        ),
        'sender_id' => array(
            'rule' => 'numeric',
            'message' => 'Please enter a valid sender ID.'
        ),
        'message' => array(
            'rule' => 'notBlank',
            'message' => 'Please enter a message.'
        )
        // Add more validation rules as needed
    );

    public $belongsTo = array(
        'Conversation',
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        ),
        'Receiver' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_id'
        )
    );
}
