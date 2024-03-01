<?php

App::uses('UsersController', 'Controller');
class UsersController extends AppController
{
    public $hasOne = 'UserProfile';
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('register', 'welcome', 'logout');
    }

    public function register()
    {
        if ($this->request->is('post')) {
            $this->User->create();

            if ($this->User->save($this->request->data)) {
                return $this->redirect(array('controller' => 'users', 'action' => 'welcome'));
            } else {
                $this->Flash->error('Registration failed. Please, try again.');
            }
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {

            if ($this->Auth->login()) {
                // User successfully logged in
                $userID = $this->Auth->user('user_id');
                // Check if UserProfile exists
                $userProfile = $this->User->UserProfile->find('first', array(
                    'conditions' => array('UserProfile.user_id' => $userID)
                ));
                // Create UserProfile if does not exists
                if (!$userProfile) {
                    return $this->redirect(array('controller' => 'userProfiles', 'action' => 'add', $userID));
                }

                // Update last login time
                $this->User->id = $userID;
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));

                // Redirect to index when user is logged in and User Profile exists
                return $this->redirect(array('controller' => 'home', 'action' => 'index', $userID));
            } else {
                $this->Flash->error('Invalid username or password, try again');
            }
        }
    }

    public function welcome()
    {
    }

    public function changePassword()
    {
        if ($this->request->is('post')) {
            $this->User->id = $this->viewVars['userId'];
            $userData = $this->User->find('first', array(
                'conditions' => array(
                    'user_id' =>  $this->User->id
                ),
                'recursive' => -1
            ));

            // Validate old password
            $passwordHasher = new BlowfishPasswordHasher();
            if (!$passwordHasher->check($this->request->data['User']['old_password'], $userData['User']['password'])) {
                $this->Flash->set('Old password does not match. Please, try again.', ['key' => 'flash_error', 'params' => ['class' => 'custom-flash-error']]);
                return $this->redirect($this->referer());
            }

            // Confirm passwords
            if ($this->request->data['User']['new_password'] !== $this->request->data['User']['password_confirm']) {
                $this->Flash->set('New passwords do not match. Please, try again.', ['key' => 'invalid_match', 'params' => ['class' => 'custom-flash-error']]);
                return $this->redirect($this->referer());
            }

            // If no validation errors, proceed with saving

            if ($this->User->saveField('password', $this->request->data['User']['new_password'])) {
                $this->User->id = $this->Auth->user('user_id');
                $this->User->saveField('modified', date('Y-m-d H:i:s'));

                $this->Flash->Set('Password has been changed.', ['key' => 'success', 'params' => ['class' => 'custom-flash-success']]);
            } else {
                $this->Flash->set_error_handler('Password could not be changed. Please, try again.');
                debug($this->User->validationErrors);
            }
        }
    }

    //TODO
    public function changeEmail()
    {
        if ($this->request->is('post')) {
            $this->User->id = $this->viewVars['userId'];
            $userData = $this->User->find('first', array(
                'conditions' => array(
                    'user_id' =>  $this->User->id
                ),
                'recursive' => -1
            ));
            // Validate old email
            if ($this->request->data['User']['old_email'] !== $userData['User']['email']) {
                $this->Flash->set('Old email does not match. Please, try again.', ['key' => 'invalid_email', 'params' => ['class' => 'custom-flash-error']]);
                return $this->redirect($this->referer());
            }

            // Confirm email
            if ($this->request->data['User']['new_email'] !== $this->request->data['User']['confirm_email']) {
                $this->Flash->set('New email do not match. Please, try again.', ['key' => 'invalid_match', 'params' => ['class' => 'custom-flash-error']]);
                return $this->redirect($this->referer());
            }

            // If no validation errors, proceed with saving
            if ($this->User->saveField('email', $this->request->data['User']['new_email'])) {
                $this->User->id = $this->Auth->user('user_id');
                $this->User->saveField('modified', date('Y-m-d H:i:s'));

                $this->Flash->Set('Email has been changed.', ['key' => 'success', 'params' => ['class' => 'custom-flash-success']]);
            } else {
                $this->Flash->set_error_handler('Password could not be changed. Please, try again.');
                debug($this->User->validationErrors);
            }
        }
    }

    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
}
