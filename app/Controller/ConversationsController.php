<?php

App::uses('ConversationsController', 'Controller');
class ConversationsController extends AppController
{


    public function newMessage()
    {
        $this->loadModel('UserProfile');

        $userProfiles = $this->UserProfile->find('list', array(
            'fields' => array('UserProfile.id', 'UserProfile.full_name'),
            'order'
        ));

        debug($userProfiles);

        $this->set(compact('userProfiles'));

        if ($this->request->is('post')) {
        }
    }

    public function sendDirectMessage($recipientId)
    {
        $loggedInUserId = $this->Auth->user('id');

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['user1_id'] = $loggedInUserId;
            $data['user2_id'] = $recipientId;

            // Save the message to the database
            if ($this->Conversation->Message->save($data)) {
                $this->Flash->success('Direct message sent successfully.');
            } else {
                $this->Flash->error('Error sending direct message. Please try again.');
            }
        }

        // Redirect to the conversation view or user profile
        return $this->redirect(['controller' => 'Conversations', 'action' => 'viewConversation', $loggedInUserId, $recipientId]);
    }
}
