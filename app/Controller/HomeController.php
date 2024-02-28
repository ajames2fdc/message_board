<?php

App::uses('AppController', 'Controller');
class HomeController extends AppController
{
    // TODO for optimization
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Load models
        $this->loadModel('UserProfile');
    }


    /**
     * Messageboard homepage controller
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function index($id = null)
    {
        // $this->set('loggedInUserId', $this->Auth->user('user_id'));
        $this->set('loggedInUserId', $id);
    }
}
