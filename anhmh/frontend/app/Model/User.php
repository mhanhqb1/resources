<?php

/* 
 * Description : User model
 * User        : KienNH
 * Date created: 2016/01/19
 */

class User extends AppModel {
    
    public $useTable = FALSE;
    
    public function validateProfile($data, &$error = '') {
        // Init
        $this->set($data['Register']);
        $validate = array();
        
        // Set rule
        $validate['name'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_NAME'),
            ),
        );
        /*$validate['sex_id'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_SEX'),
            ),
        );
        $validate['birthday'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_BIRTHDAY'),
            ),
        );*/
        
        $validate['zipcode1'] = array(
            /*'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_ZIPCODE'),
            ),*/
            'validate_format' => array(
                'rule' => '/^[0-9]+$/',
                'message' => __('PRF_ERROR_MESSAGE_FORMAT_ZIPCODE'),
                'allowEmpty' => true
            ),
            'maxLenght' => array(
                'rule' => array('between', 3, 3),
                'message' => __('PRF_ERROR_MESSAGE_FORMAT_ZIPCODE'),
                'allowEmpty' => true
            ),
        );
        $validate['zipcode2'] = array(
            /*'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_ZIPCODE'),
            ),*/
            'validate_format' => array(
                'rule' => '/^[0-9]+$/',
                'message' => __('PRF_ERROR_MESSAGE_FORMAT_ZIPCODE'),
                'allowEmpty' => true
            ),
            'maxLenght' => array(
                'rule' => array('between', 4, 4),
                'message' => __('PRF_ERROR_MESSAGE_FORMAT_ZIPCODE'),
                'allowEmpty' => true
            ),
        );
        
        $validate['user_physical_type_id'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('PRF_ERROR_MESSAGE_MISSING_PHYSICAL_TYPE'),
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
     * Validate form when chagne password
     * @param array $data
     * @param array $error
     * @return boolean
     */
    public function validateChangePassword($data, &$error = '') {
        // Init
        $this->set($data['ChangePassword']);
        $validate = array();
        
        // Set rule
        $validate['password_old'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('LABEL_REQUIRE_PASSWORD_OLD'),
            ),
            'maxLenght' => array(
                'allowEmpty' => false,
                'rule' => array('between', 6, 40),
                'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
            ),
        );
        $validate['password'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('LABEL_REQUIRE_PASSWORD_NEW'),
            ),
            'maxLenght' => array(
                'allowEmpty' => false,
                'rule' => array('between', 6, 40),
                'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
            ),
        );
        $validate['password_confirm'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __('LABEL_REQUIRE_PASSWORD_CONFIRM'),
            ),
            'maxLenght' => array(
                'allowEmpty' => false,
                'rule' => array('between', 6, 40),
                'message' => __('MESSAGE_WRONG_PASSWORD_LENGTH'),
            ),
            'compare' => array(
                'rule' => array('check_match_password'),
                'message' => __('MESSAGE_PASSWORD_CONFIRM_NOT_MATCH'),
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
    
    public function check_match_password($password_confirm) {
        if (!isset($this->data[$this->alias]['password'])) {
            return false;
        }
        return $password_confirm['password_confirm'] == $this->data[$this->alias]['password'];
    }
    
}
