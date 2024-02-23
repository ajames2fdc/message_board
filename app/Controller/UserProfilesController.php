<?php

App::uses('AppController', 'Controller');

class UserProfilesController extends AppController
{
    public $uses = array('UserProfile'); // Add other models as needed

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Add any specific controller-wide configurations here
    }

    public function index($id = null)
    {
    }

    public function add()
    {
        $this->loadModel('User');
        if ($this->request->is('post')) {
            $this->UserProfile->create();
            $uploadedFile = $this->request->data['UserProfile']['profile_picture'];

            // File handling
            if (!empty($uploadedFile['name'])) {
                // Generate a unique filename for the uploaded file
                $filename = md5(uniqid() . time()) . '.' . pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

                // Move the file to the upload folder
                move_uploaded_file($uploadedFile['name'], WWW_ROOT . 'uploads' . DS . $filename);

                // Save the filename to the database
                $this->request->data['UserProfile']['profile_picture'] = $filename;
            }

            $user_id = $this->Auth->user('user_id');
            $this->request->data['UserProfile']['user_id'] = $user_id;

            $this->request->data['UserProfile']['birthday'] = $this->request->data['birthday'];


            // Check if the user_id exists in the users table
            if (!$this->User->exists($user_id)) {
                // Handle the case where the user_id does not exist
                $this->Flash->error('Invalid user ID');
                $this->redirect(array('action' => 'add'));
                return;
            }

            // Continue with saving the data
            if ($this->UserProfile->save($this->request->data)) {
                $this->Flash->success(('The user profile has been created.'));
                return $this->redirect(array('controller' => 'UserProfiles', 'action' => 'index'));
            } else {
                $this->Flash->error('The profile could not be saved. Please, try again.');
            }
        }
    }

    public function edit($id = null)
    {
        $this->UserProfile->id = $id;
        if (!$this->UserProfile->exists()) {
            throw new NotFoundException(__('Invalid user profile'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->UserProfile->save($this->request->data)) {
                $this->Flash->success('User profile has been updated.');
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error('Unable to update user profile. Please, try again.');
            }
        } else {
            $this->request->data = $this->UserProfile->read(null, $id);
        }

        $this->set('id', $id);
    }

    private function transformBirthday($birthday)
    {
        return date('Y-m-d', strtotime($birthday));
    }
}
