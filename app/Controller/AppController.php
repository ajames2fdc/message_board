<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = array(
        'DebugKit.Toolbar',
        'Flash',
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'userProfiles',
                'action' => 'add'
            ),
            'logoutRedirect' => '/',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'passwordHasher' => 'Blowfish',
                )
            ),
            'authorize' => array('Controller'),
            'authError' => 'You are not authorized to access that location.'
        )
    );

    public function isAuthorized($user)
    {
        return true;
    }

    function checkFileExists($fileName)
    {
        $filePath = WWW_ROOT . 'uploads' . DS . $fileName;

        if (!file_exists($filePath)) {
            return false;
        }

        return file_exists($filePath);
    }

    function baseUrl($path = '')
    {
        // Adjust the base URL as needed
        $baseUrl = 'http://localhost/message-board/';

        // Remove leading slash from the path to prevent double slashes
        $path = ltrim($path, '/');

        // Combine the base URL and the path
        return $baseUrl . $path;
    }

    function setFullName($firstName, $lastName)
    {
        $formattedFirstName = ucfirst($firstName);
        $formattedLastName = ucfirst($lastName);

        return $formattedFirstName . " " . $formattedLastName;
    }

    public function beforeFilter()
    {;
        $loggedIn = (bool)$this->Auth->user();
        $this->set('userName', $this->Auth->user('user_name'));
        $this->set('userId', $this->Auth->user('user_id'));
        $this->set('loggedIn', $loggedIn);
        $this->set('userData', $this->Auth->user());
        $this->Auth->allow('login');
    }
}
