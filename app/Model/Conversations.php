<?php
App::uses('Conversations', 'Model');

class Conversations extends Model
{
    public $validate = array(
        'receiver_id' => array(
            'rule' => 'numeric',
            'message' => 'Please select a recipient'
        ),
        'sender_id' => array(
            'rule' => 'numeric',
            'message' => 'Error user.'
        ),
    );


    public $belongsTo = array(
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id'
        ),
        'Receiver' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_id'
        ),
        'Conversation'
    );

    public $hasMany = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'conversation_id'
        )
    );
}
