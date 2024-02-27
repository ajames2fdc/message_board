<?php

App::uses('UserProfilesController', 'Controller');

class UserProfilesController extends AppController
{
    public $uses = array('UserProfile'); // Add other models as needed

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->loadModel('User');
        $this->loadModel('UserProfile');
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

        // Find the profile data
        $profileData = $this->UserProfile->find('first', array(
            'conditions' => array('UserProfile.user_id' => $id)
        ));

        // Check if the profile picture file exists
        $fileExists = $this->checkFileExists($profileData['UserProfile']['profile_picture']);

        if (!$fileExists) {
            $profileData['UserProfile']['file_path'] = $this->baseUrl('/uploads/default.png');
            $profileData['UserProfile']['alt'] = 'default';
        } else {
            $profileData['UserProfile']['file_path'] = $this->baseUrl('/uploads/' . $profileData['UserProfile']['profile_picture']);
            $profileData['UserProfile']['alt'] = $profileData['UserProfile']['profile_picture'];
        }

        $this->set('profileData', $profileData);
    }

    /** Input: User_id */
    public function add($id = null)
    {
        // Check if id is valid
        if (!$id) {
            throw new NotFoundException('Invalid user');
        }

        if ($this->request->is('post')) {
            $this->UserProfile->create();
            $uploadedFile = $this->request->data['UserProfile']['profile_picture'];
            // File handling
            if (!empty($uploadedFile['name'])) {
                $file = $this->request->data['UserProfile']['profile_picture'];

                // Set the directory where uploaded files will be stored
                $uploadDir = WWW_ROOT . 'uploads' . DS;

                // Generate a unique filename for the uploaded file
                $filename = md5(uniqid() . time()) . '.' . pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

                // Set the full path for saving
                $uploadPath = $uploadDir . $filename;

                // Move the uploaded file to the specified directory
                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    // Save the filename to the database
                    $this->request->data['UserProfile']['profile_picture'] = $filename;
                    $this->Flash->set('File uploaded successfully.');
                } else {
                    // Handle file upload error
                    $this->Flash->set('Error uploading file. Please try again.');
                    return $this->redirect(array('action' => 'add'));
                };
            }

            $this->request->data['UserProfile']['user_id'] = $id;
            $this->request->data['UserProfile']['birthday'] = $this->request->data['birthday'];
            // debug($this->request->data);

            debug($this->request->data);
            // Continue with saving the data
            if ($this->UserProfile->save($this->request->data)) {
                $this->Flash->success(('The user profile has been created.'));
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
            debug($dataToSave);

            if ($this->UserProfile->save($dataToSave)) {
                $this->Flash->success('User profile has been updated.');

                // return $this->redirect(array('controller' => 'userProfiles', 'action' => 'view', $id));
            } else {
                $this->Flash->error('Unable to update user profile. Please, try again.');
                debug($this->UserProfile->validationErrors);
            }
        } else {
            // $this->request->data = $this->UserProfile->read(null, $id);
            $this->request->data = $userProfile;
        }
    }

    private function checkFileExists($fileName)
    {
        $filePath = WWW_ROOT . 'uploads' . DS . $fileName;

        if (!file_exists($filePath)) {
            return false;
        }

        return file_exists($filePath);
    }
}
