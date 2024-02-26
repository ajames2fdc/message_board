<?php

App::uses('UserProfilesController', 'Controller');

class UserProfilesController extends AppController
{
    public $uses = array('UserProfile'); // Add other models as needed

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Add any specific controller-wide configurations here
    }

    /**
     * view function
     *
     * @param User id   
     * @throws NotFoundException Invalid user
     * @return void
     */

    /**
     * View function for retrieving user profile data.
     *
     * @param null|int User id
     * @throws NotFoundException If the user ID is invalid
     * @return void
     */
    public function view($id = null)
    {
        // Check if id is valid
        if (!$id) {
            throw new NotFoundException('Invalid user');
        }

        $this->loadModel('UserProfiles');

        $profileData = $this->UserProfile->find('first', array(
            'conditions' => array('UserProfile.user_id' => $id)
        ));

        $this->set('profileData', $profileData);
    }

    /** Input: User_id */
    public function add($id = null)
    {
        // Check if id is valid
        if (!$id) {
            throw new NotFoundException('Invalid user');
        }

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

            $this->request->data['UserProfile']['user_id'] = $id;
            $this->request->data['UserProfile']['birthday'] = $this->request->data['birthday'];
            // debug($this->request->data);

            debug($this->request->data);
            // Continue with saving the data
            if ($this->UserProfile->save($this->request->data)) {
                $this->Flash->success(('The user profile has been created.'));
                $this->loadModel('UserProfile');
                $userProfile = $this->UserProfile->findById($id);


                return $this->redirect(array('controller' => 'userProfiles', 'action' => 'view', $id));
            } else {
                $this->Flash->error('The profile could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Edit function
     *
     * @param User $id 
     * @throws NotFoundException Invalid user profile
     * @return void
     */
    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid user profile'));
        }

        // Load the model
        $this->loadModel('UserProfile');

        // Retrieve existing data so we can pre-populate the form
        $userProfile = $this->UserProfile->find('first', array(
            'conditions' => array('UserProfile.user_id' => $id)
        ));

        if (!$userProfile) {
            throw new NotFoundException(__('Invalid user profile'));
        }

        // Set the User Profile model into the view
        $this->set('userProfile', $userProfile);
        // Updating the User Profile
        if ($this->request->is('post') || $this->request->is('put')) {


            // Validate and update data
            $this->UserProfile->id = $userProfile['UserProfile']['id'];
            $dataToSave = $this->request->data('UserProfile');
            $dataToSave['birthday'] = $this->request->data['birthday'];

            if ($this->UserProfile->save($dataToSave)) {
                $this->Flash->success('User profile has been updated.');

                return $this->redirect(array('controller' => 'userProfiles', 'action' => 'view', $id));
            } else {
                $this->Flash->error('Unable to update user profile. Please, try again.');
                debug($this->UserProfile->validationErrors);
            }
        } else {
            // $this->request->data = $this->UserProfile->read(null, $id);
            $this->request->data = $userProfile;
        }
    }
}
