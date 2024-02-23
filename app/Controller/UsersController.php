<?php

App::uses('AppController', 'Controller');
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

                // Check if UserProfile exists
                $userProfile = $this->User->UserProfile->find('first', array(
                    'conditions' => array('UserProfile.user_id' => $this->Auth->user('id'))
                ));

                // Create UserProfile if not exists
                if (!$userProfile) {
                    $this->Flash->set('User_id', ['key' => $this->Auth->user('id')]);
                    return $this->redirect(array('controller' => 'user_profiles', 'action' => 'add'));
                }

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Invalid username or password, try again');
            }
        }
    }

    public function welcome()
    {
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
