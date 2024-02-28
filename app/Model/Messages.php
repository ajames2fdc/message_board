<?php
App::uses('Messages', 'Model');

class Messages extends Model
{
    public $actsAs = array('Containable');

    public $validate = array(
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
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id',
            'fields' => array('Sender.*', 'UserProfile.*'),
        ),
        'Receiver' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_id',
            'fields' => array('Receiver.*', 'UserProfile.*'),
        ),
    );
}
