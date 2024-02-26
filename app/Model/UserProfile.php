<?php

App::uses('UserProfile', 'Model');

class UserProfile extends AppModel
{
    public $virtualFields = array(
        'full_name' => 'CONCAT(UserProfile.first_name, " ", UserProfile.last_name)'
    );
    public $primaryKey = 'id';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    public $validate = array(
        'first_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter a valid user ID',
            ),
        ),
        'last_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter a valid user ID',
            ),
        ),
        'user_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'user_id not properly fetched'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Profile already existed'
            ),
            'number' => array(
                'rule' => 'numeric',
                'message' => 'user_id is invalid'
            ),
        ),
        'gender' => array(
            'validEnum' => array(
                'rule' => array('inList', array('Male', 'Female', 'Other')),
                'message' => 'Please select a valid gender',
            ),
        ),
        'birthday' => array(
            'date' => array(
                'rule' => array('date', 'ymd'),
                'message' => 'Please enter a valid date in the format YYYY-MM-DD',
            ),
        ),
        'hobby' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Hobby must not exceed 255 characters',
            ),
        ),
        'bio' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 65535),
                'message' => 'Bio must not exceed 65535 characters',
            ),
        ),
        'profile_picture' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Profile picture URL must not exceed 255 characters',
            ),
        ),
    );
}
