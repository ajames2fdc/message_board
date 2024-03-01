<?php
App::uses('User', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends Model
{
    public $hasOne = array(
        'UserProfile',
    );

    public $primaryKey = 'user_id';

    public $validate = array(
        'user_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Username is required'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Username must be unique'
            ),
            'length' => array(
                'rule' => array('between', 3, 20),
                'message' => 'Username must be between 3 and 20 characters long'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Email must be unique'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'length' => array(
                'rule' => array('between', 6, 255),
                'message' => 'Password must be at least 6 characters long'
            )
        ),
        'password_confirm' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Please confirm your password'
            ),
            'matchPassword' => array(
                'rule' => array('validatePasswordConfirmation'),
                'message' => 'Passwords do not match'
            )
        ),
        'old_password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'length' => array(
                'rule' => array('between', 6, 255),
                'message' => 'Password must be at least 6 characters long'
            ),

        ),
        'new_password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'minLength' => array(
                'rule' => array('between', 6, 255),
                'message' => 'Password must be at least 6 characters long.',
                'allowEmpty' => false,
                'on' => 'update',
            ),
        ),
        'confirm_password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
        ),
        'old_email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            )
        ),
        'new_email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            )
        ),
        'confirm_email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            )
        ),
    );

    public function validatePasswordConfirmation($data)
    {
        $password = current($data);
        return ($password === $this->data[$this->alias]['password']);
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {

            /**Start of Encryption*/
            $plainPassword = $this->data[$this->alias]['password'];
            // Generate a Blowfish salt
            $blowfishSalt = Security::hash(Security::randomBytes(22), 'blowfish');

            // Hash the password with the salt
            $hashedPassword = Security::hash($plainPassword, 'blowfish', $blowfishSalt);
            /** End of encryption */

            $this->data[$this->alias]['password'] = $hashedPassword;
        }
        return true;
    }
}
