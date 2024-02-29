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
    public function conversation($id = null)
    {
        $userId = $this->viewVars['userId'];

        $messagesData = $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    array('sender_id' => $userId, 'receiver_id' => $id),
                    array('sender_id' => $id, 'receiver_id' => $userId),
                ),
            ),
        ));

        $sender = $this->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $userId
            ),
        ));

        $receiver = $this->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $id
            ),
        ));
        $senderData['Sender'] = $sender['UserProfile'];
        $receiverData['Receiver'] = $receiver['UserProfile'];

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

        // Sending new message into the conversation
        if ($this->request->is('post')) {

            // Transform the data
            $messageToSave = $this->request->data;
            $messageToSave['Message']['sender_id'] = $userId;
            $messageToSave['Message']['receiver_id'] = $id;
            // Continue to save
            $this->Message->create();
            // Save the message to the database
            if ($this->Message->save($messageToSave)) {
                $receiverId = $messageToSave['Message']['receiver_id'];
                return $this->redirect(array('controller' => 'messages', 'action' => 'conversation', $receiverId));
            } else {
                debug($this->Message->validationErrors);
            }
        }
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
                debug($messageToSave);
                // Retrieve the message ID
                return $this->redirect(array('controller' => 'messages', 'action' => 'conversation', $receiverId));
            } else {
                debug($this->Message->validationErrors);
            }
        }
    }

    public function messageList()
    {
        $userId = $this->viewVars['userId'];
        $distinctUsersQuery = $this->Message->find('all', array(
            'fields' => array(
                'DISTINCT IF(Message.sender_id = ' . $userId . ', Message.receiver_id, Message.sender_id) AS distinctUser',
            ),
            'conditions' => array(
                'OR' => array(
                    'Message.sender_id' => $userId,
                    'Message.receiver_id' => $userId,
                ),
            ),
        ));

        $distinctUsers =  Hash::extract($distinctUsersQuery, '{n}.0.distinctUser');
        $userData = $this->UserProfile->find('all', array(
            'conditions' => array('UserProfile.user_id' => $distinctUsers),
        ));

        $messagesData = $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'sender_id' => $userId,
                    'receiver_id IN' => $distinctUsers,
                ),
            ),
        ));
        // // File Handling
        foreach ($userData as $key => $value) {
            $fileExists = $this->checkFileExists($value['UserProfile']['profile_picture']);
            // File handling
            if (!$fileExists) {
                $userData[$key]['UserProfile']['file_path'] = $this->baseUrl('/img/default.png');
                $userData[$key]['UserProfile']['alt'] = 'default';
            } else {
                $userData[$key]['UserProfile']['file_path'] = $this->baseUrl('/uploads/' . $value['UserProfile']['profile_picture']);
                $userData[$key]['UserProfile']['alt'] = $value['UserProfile']['profile_picture'];
            }
        }
        $this->set('messagesData', $messagesData);
        $this->set(compact('userData'));
    }

    public function deleteMessages($id = null)
    {
        $this->autoRender = false;
        // $userId = $this->viewVars['userId'];
        // $receiverId = $id;
        // if ($this->request->is('ajax')) {
        //     $messagesData = $this->Message->find('all', array(
        //         'conditions' => array(
        //             'OR' => array(
        //                 array('sender_id' => $userId, 'receiver_id' => $id),
        //                 array('sender_id' => $id, 'receiver_id' => $userId),
        //             ),
        //         ),
        //     ));
        //     $this->autoRender = false;
        //     $this->response->type('json');
        //     if ($messagesData) {
        //         $this->Message->deleteAll($messagesData);
        //         echo json_encode(['success' => true]);
        //     } else {
        //         echo json_encode(['fail' => false]);
        //     }
        //     $this->response->type('json');
        //     echo json_encode(['debug' => 'Controller is reached!']);
        // }
    }
}
