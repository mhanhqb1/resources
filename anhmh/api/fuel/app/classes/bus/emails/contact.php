<?php

namespace Bus;

/**
 * Send contact mail
 *
 * @package Bus
 * @created 2016-04-28
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Emails_Contact extends BusAbstract {
    
    /** @var array $_required field require */
    protected $_required = array(
        'name',
        'group_name',
        'email',
        'tel',
        'comments',
        'language_type'
    );

    /** @var array $_length Length of fields */
    protected $_email_format = array(
        'email',
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'language_type',
    );

    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function operateDB($data){
        try {
            $this->_response = \Model_Mail_Send_Log::contact($data);
            return $this->result(\Model_Mail_Send_Log::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
