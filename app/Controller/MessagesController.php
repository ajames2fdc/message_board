<?php

App::uses('MessagesController', 'Controller');
class MessagesController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();

        // Load models
        $this->loadModel('UserProfile');
        $this->loadModel('User');
    }

    /**
     * This function handles the conversation between users
     *
     */
    public function conversation($receiverId = null)
    {
        $senderId = $this->viewVars['userId'];
        debug($receiverId);

        $messagesData = $this->Message->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                ),
            ),
        ));
        debug($senderId);
        debug($messagesData);
        $sender = $this->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $senderId
            ),
        ));

        $receiver = $this->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $receiverId
            ),
        ));
        $senderData['Sender'] = $sender['UserProfile'];
        $receiverData['Receiver'] = $receiver['UserProfile'];

        foreach ($messagesData as $message) {

            // Access the date-time value from the array
            $originalDateTime = $message['Message']['created_at'];

            // Create a DateTime object from the original date-time string
            $dateTimeObj = new DateTime($originalDateTime);

            // Format the date-time as needed (replace 'Y-m-d H:i:s' with your desired format)
            $formattedDateTime = $dateTimeObj->format('Y-m-d H:i:s');

            // Add the formatted date-time to the array
            $message['Message']['formatted_created_at'] = $formattedDateTime;

            // Add the message to the formatted array
        }

        // Image handling on Sender
        $fileExists = $this->checkFileExists($senderData['Sender']['profile_picture']);
        // File handling
        if (!$fileExists) {
            $senderData['Sender']['file_path'] = $this->baseUrl('/img/default.png');
            $senderData['Sender']['alt'] = 'default';
        } else {
            $senderData['Sender']['file_path'] = $this->baseUrl('/uploads/' . $senderData['Sender']['profile_picture']);
            $senderData['Sender']['alt'] = $senderData['Sender']['profile_picture'];
        }
        // Image handling on Receiver
        $fileExists = $this->checkFileExists($receiverData['Receiver']['profile_picture']);
        // File handling
        if (!$fileExists) {
            $receiverData['Receiver']['file_path'] = $this->baseUrl('/img/default.png');
            $receiverData['Receiver']['alt'] = 'default';
        } else {
            $receiverData['Receiver']['file_path'] = $this->baseUrl('/uploads/' . $receiverData['Receiver']['profile_picture']);
            $receiverData['Receiver']['alt'] = $receiverData['Receiver']['profile_picture'];
        }

        $this->set('senderData', $senderData);
        $this->set('receiverData', $receiverData);
        $this->set(compact('messagesData'));
    }

    /**
     * Send new message
     *
     */
    public function newMessage()
    {
        $userId = $this->viewVars['userId'];
        // Pre-filled data from user profile
        $userProfiles = $this->UserProfile->find('list', array(
            'fields' => array('UserProfile.user_id', 'UserProfile.full_name'),
            'order' => 'UserProfile.full_name',
            'conditions' => array(
                'UserProfile.user_id !=' =>  $userId
            )
        ));

        // Set data in the view
        $this->set(compact('userProfiles'));

        if ($this->request->is('post')) {

            // Transform the data
            $messageToSave = $this->request->data;
            $messageToSave['Message']['sender_id'] = $userId;
            // Continue to save
            $this->Message->create();
            // Save the message to the database
            if ($this->Message->save($messageToSave)) {
                $receiverId = $messageToSave['Message']['receiver_id'];
                debug($receiverId);
                // Retrieve the message ID
                return $this->redirect(array('controller' => 'messages', 'action' => 'conversation', $receiverId));
            } else {
                debug($this->Message->validationErrors);
            }
        }
    }

    public function messageList()
    {
        // TODO receieve it from home
        $senderId = $this->viewVars['userId'];
        $messagesData = $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Message.sender_id' => $senderId,
                    'Message.receiver_id' => $senderId
                )
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
