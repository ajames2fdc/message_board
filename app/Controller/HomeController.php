<?php

App::uses('AppController', 'Controller');
class HomeController extends AppController
{
    /**
     * Messageboard homepage controller
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function index()
    {
        $this->set('loggedInUserId', $this->Auth->user('user_id'));
    }
}
