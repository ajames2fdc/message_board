<?php

App::uses('MessagesController', 'Controller');
class MessagesController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();

        // Load models
        $this->loadModel('UserProfile');
        $this->loadModel('Conversations');
    }

    /**
     * Add new message to the conversation
     *
     */
    public function newMessage()
    {
        // Pre-filled data from user profile
        $userProfiles = $this->UserProfile->find('list', array(
            'fields' => array('UserProfile.user_id', 'UserProfile.full_name'),
            'order' => 'UserProfile.full_name',
            'conditions' => array(
                'UserProfile.user_id !=' =>  $this->Auth->user('user_id')
            )
        ));

        // Set data in the view
        $this->set(compact('userProfiles'));

        if ($this->request->is('post')) {

            // Transform the data
            $messageToSave = $this->request->data;
            $messageToSave['Message']['sender_id'] = $this->Auth->user('user_id');

            // Fetch conversation data
            $this->Conversations->create();
            $existingConversation = $this->Conversations->find('first', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'Conversations.sender_id' => $messageToSave['Message']['sender_id'],
                            'Conversations.receiver_id' => $messageToSave['Message']['receiver_id']
                        ),
                        // array(
                        //     'Conversations.sender_id' => $messageToSave['Message']['receiver_id'],
                        //     'Conversations.receiver_id' => $messageToSave['Message']['sender_id']
                        // )
                    )
                )
            ));
            debug($messageToSave);
            // If conversation does not exist
            if (!$existingConversation) {
                // Save necessary data
                $conversationData['receiver_id'] = $messageToSave['Message']['receiver_id'];
                $conversationData['sender_id'] = $messageToSave['Message']['sender_id'];

                // Save the conversation
                if ($this->Conversations->save($conversationData)) {
                    $messageToSave['Message']['conversation_id'] = $this->Conversations->id;
                } else {
                    debug($this->Conversations->validationErrors);
                }
            } else {
                $messageToSave['Message']['conversation_id'] = $existingConversation['Message'][0]['conversation_id'];
            }
            // Continue to save
            $this->Message->create();

            // Save the message to the database
            if ($this->Message->save($messageToSave)) {
                // Retrieve the message ID
                debug('Message saved');
            } else {
                debug($this->Message->validationErrors);
            }
        }
    }

    public function messageList()
    {
        // TODO receieve it from home
        $senderId = $this->Auth->user('user_id');
        $messagesData = $this->Message->find('all', array(
            'conditions' => array(
                'Message.sender_id' => $senderId
            ),
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'Sender',
                    'type' => 'LEFT',
                    'conditions' => array('Sender.user_id = Message.sender_id')
                ),
                array(
                    'table' => 'user_profiles',
                    'alias' => 'SenderProfile',
                    'type' => 'LEFT',
                    'conditions' => array('SenderProfile.user_id = Sender.user_id')
                ),
                array(
                    'table' => 'users',
                    'alias' => 'Receiver',
                    'type' => 'LEFT',
                    'conditions' => array('Receiver.user_id = Message.receiver_id')
                ),
                array(
                    'table' => 'user_profiles',
                    'alias' => 'ReceiverProfile',
                    'type' => 'LEFT',
                    'conditions' => array('ReceiverProfile.user_id = Receiver.user_id')
                ),
            ),
            'fields' => array('Message.*', 'SenderProfile.*', 'ReceiverProfile.*'),

            'group' => 'Message.id',
        ));

        // Transform data to full name
        foreach ($messagesData as &$messageData) {
            $messageData['ReceiverProfile']['full_name'] = $this->setFullName($messageData['ReceiverProfile']['first_name'], $messageData['ReceiverProfile']['last_name']);
            $messageData['SenderProfile']['full_name'] = $this->setFullName($messageData['SenderProfile']['first_name'], $messageData['SenderProfile']['last_name']);
        }


        $this->set(compact('messagesData'));
    }
}
