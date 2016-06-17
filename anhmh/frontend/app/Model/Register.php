<?php

/* 
 * Description : Login model
 * User        : ThaiLH
 * Date created: 2015/11/05
 */

class Register extends AppModel {
    
    public $useTable = FALSE;
    
    /**
     * Verify data before the processing to login.
     *
     * @author ThaiLH
     * @param array $data Input array.
     * @return bool or error message.
     */
    public function validate($data, &$error = '') {
        // Init
        $this->set($data['Register']);
        $validate = array();
        
        // Set rule
        $validate['zipcode1'] = array(           
            'length' => array(
                'rule' => array('length', 3),
                'message' => __('MESSAGE_WRONG_PHONE_LENGTH'),
            )
        );
        
        $validate['password'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('login', 'LANG_LOGIN_REQUIRE_PASSWORD'),
            ),
        );
        /*
        $validate['passwordConfirm'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('login', 'LANG_LOGIN_REQUIRE_PASSWORD_CONFIRM'),
            ),
            'compare' => array(
                'rule' => array('validatePasswords'),
                'message' => __d('login', 'LANG_LOGIN_PASSWORD_NOT_MATCH'),
            )
        );
         * 
         */
        
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

}
