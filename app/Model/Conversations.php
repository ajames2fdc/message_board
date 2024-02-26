<?php
App::uses('Conversations', 'Model');

class Conversations extends Model
{
    public $belongsTo = array(
        'User1' => array(
            'className' => 'User',
            'foreignKey' => 'user1_id'
        ),
        'User2' => array(
            'className' => 'User',
            'foreignKey' => 'user2_id'
        )
    );

    public $hasMany = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'conversation_id'
        )
    );
}
