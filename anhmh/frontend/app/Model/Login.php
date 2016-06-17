<?php

/* 
 * Description : Login model
 * User        : KienNH
 * Date created: 2015/11/05
 */

class Login extends AppModel {
    
    public $useTable = FALSE;
    public $name = 'Login';
    
    /**
     * Verify data before the processing to login.
     *
     * @author KienNH
     * @param array $data Input array.
     * @return bool or error message.
     */
    public function validateLogin($data, &$error = '') {
        // Init
        $this->set($data['Login']);
        $validate = array();
        
        // Set rule
        $validate['email'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('login', 'LANG_LOGIN_REQUIRE_EMAIL'),
            ),
            'maxLenght' => array(
                'allowEmpty' => false,
                'rule' => array('maxlength', 40),
                'message' => __d('login', 'LANG_LOGIN_EMAIL_MAX_LENGTH')
            ),
            'format' => array(
                'rule' => '/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/',
                'message' => __d('login', 'LANG_LOGIN_EMAIL_INVALID')
            ),
        );
        
        $validate['password'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('login', 'LANG_LOGIN_REQUIRE_PASSWORD'),
            ),
            'maxLenght' => array(
                'allowEmpty' => false,
                'rule' => array('between', 6, 40),
                'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
            ),
        );
        
        // Validate
        $this->validate = $validate;
        
        // Check result
        if ($this->validates()) {
            return TRUE;
        } else {
            $error = $this->validationErrors;
        }
        return FALSE;
    }
    
    /**
     * Compare 2 password
     * 
     * @return boolean
     */
    public function validatePasswords() {
        return $this->data[$this->alias]['password'] === $this->data[$this->alias]['passwordConfirm'];
    }
    
    /**
     * Verify data before the processing to remind password.
     *
     * @author ThaiLH
     * @param array $data Input array.
     * @return bool Returns the boolean.
     */
    public function validateForgetPassword($data) {
        $this->set($data[$this->name]);
        $this->validate = array();
        $this->validate = array(
            'email' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('MESSAGE_EMAIL_CAN_NOT_EMPTY'),
                ),
                'validate_format' => array(
                    'rule' => '/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/',
                    'message' => __('MESSAGE_FORMAT_INVALID_EMAIL')
                ),
            )
        );
        if ($this->validates()) {
            return true;
        }
        return false;
    }

    /**
     * Verify data before the processing to reset password.
     *
     * @author ThaiLH
     * @param array $data Input array.
     * @return bool Returns the boolean.
     */
    public function validateResetPassword($data) {
        $this->set($data[$this->name]);
        $this->validate = array(
            'password' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('MESSAGE_PASSWORD_NOT_EMPTY'),
                ),
                'validate_format' => array(
                    'rule' => '/^[0-9a-zA-Z]+$/',
                    'message' => __('MESSAGE_FORMAT_NUMBER_AND_ALPHABET_ONLY')
                ),
                'maxLength' => array(
                    'allowEmpty' => false,
                    'rule' => array('between', 6, 40),
                    'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
                ),
            ),
            'password_confirm' => array(
                'notBlank' => array(
                    'rule' => 'notBlank',
                    'message' => __('MESSAGE_CONFIRM_PASSWORD_EMPTY'),
                ),
                'compare' => array(
                    'rule' => array('validate_passwords'),
                    'message' => __('MESSAGE_PASSWORD_CONFIRM_NOT_MATCH'),
                ),
                'validate_format' => array(
                    'rule' => '/^[0-9a-zA-Z]+$/',
                    'message' => __('MESSAGE_FORMAT_NUMBER_AND_ALPHABET_ONLY')
                ),
                'maxLength' => array(
                    'allowEmpty' => false,
                    'rule' => array('between', 6, 40),
                    'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
                ),
            )
        );
        if ($this->validates()) {
            return true;
        }
        return false;
    }
    
    /**
     * Validate password.
     *
     * @author thailh
     * @return bool Returns the boolean.
     */
    public function validate_passwords() {
        if ($this->data[$this->name]['password'] != '') {
            return $this->data[$this->name]['password'] === $this->data[$this->name]['password_confirm'];
        } else {
            return true;
        }
    }

}
