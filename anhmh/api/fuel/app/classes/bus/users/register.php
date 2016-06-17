<?php

namespace Bus;

use Lib\Util;

/**
 * add register
 *
 * @package Bus
 * @created 2015-04-01
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Users_Register extends BusAbstract {

    /** @var array $_required field require */
    protected $_required = array(
        'name',
        'kana',
        'email',
        //'birthday',
        //'phone',
        'password',
        'is_magazine'
    );

    /** @var array $_email_format field email */
    protected $_email_format = array(
        'email'
    );

    /** @var array $_kana_format number */
    protected $_kana_format = array(
        'kana',
    );
    
    /** @var array $_number_format number */
    protected $_number_format = array(
        'sex',
    );

    /** @var array $_date_format date */
    protected $_date_format = array(
        'birthday',
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'email' => array(1, 255),
        'name' => array(1, 64),
        'kana' => array(1, 64),
        'sex' => 1,
        'address1' => array(1, 128),
        'address2' => array(1, 128),
        'password' => array(6, 40)
    );

    /**
     * call function register() from model User Activation
     *
     * @created 2014-12-18
     * @updated 2014-12-18
     * @access public
     * @author Hoang Gia Thong
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data) {
        try {
            $this->_response = \Model_User::register($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
