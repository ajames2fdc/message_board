<?php

App::uses('UsersController', 'Controller');
class UsersController extends AppController
{
    public $hasOne = 'UserProfile';
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('register'); // Allow public access to the register action
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
                    'conditions' => array('UserProfile.user_id' => $this->Auth->user('user_id'))
                ));

                // Create UserProfile if does not exists
                if (!$userProfile) {
                    return $this->redirect(array('controller' => 'userProfiles', 'action' => 'add', $userID));
                }


                // Redirect to index when user is logged in and User Profile exists
                // TODO change to index
                return $this->redirect(array('controller' => 'userProfiles', 'action' => 'view', $userID));
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

            $userId = $this->Auth->user('user_id');
            $oldPassword = $this->request->data['User']['old_password'];
            $newPassword = $this->request->data['User']['new_password'];
            $confirmPassword = $this->request->data['User']['confirm_password'];

            if ($this->User->changePassword($userId, $oldPassword, $newPassword, $confirmPassword)) {
                $this->Flash->set('Password changed successfully.', 'flash/success');
                $this->redirect('/');
            } else {
                $this->Flash->set('Failed to change password. Please check your input.', 'flash/error');
            }
        }
    }

    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect(array('controller' => 'Users', 'action' => 'login'));
    }
}
