<?php

/* 
 * Description : Setting model
 * User        : quannq@evolableasia.vn
 */

class Setting extends AppModel {
    
    public $useTable = FALSE;
    
    /**
     * Verify data before the processing to update setiing.
     *
     * @author quannq@evolableasia.vn
     * @param array $data Input array.
     * @return bool
     */
    public function validate($data, &$error = '') {
        // Init
        $this->set($data['Setting']);
        $validate = array();
        
        // Set rule
        $validate['name'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('setting', 'LANG_SETTING_NAME_REQUIRE'),
            )
        );

        $validate['value'] = array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => __d('setting', 'LANG_SETTING_VALUE_REQUIRE'),
            ),
            'format' => array(
                'rule' => '/[0|1]/',
                'message' => __d('login', 'LANG_SETTING_VALUE_INVALID')
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

}
