<?php

namespace Bus;

/**
 * get detail user profiles
 *
 * @package Bus
 * @created 2014-11-25
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class UserActivations_Detail extends BusAbstract
{

    //check length
    protected $_length = array(
        'token' => array(0, 255),
        'expire_date' => array(1, 11),
        'regist_type' => array(0, 20),
        'disable' => 1,
    );
    //check number
    protected $_number_format = array(
        'expire_date',
        'disable'
    );
    //check email
    protected $_email_format = array(
        'email',
    );

    /**
     * get detail user profile by id
     *
     * @created 2014-11-25
     * @updated 2014-11-25
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try
        {
            $conditions['where'] = array();
            if (!empty($data['email']))
            {
                $conditions['where'][] = array(
                    'email' => $data['email']
                );
            }
            if (!empty($data['token']))
            {
                $conditions['where'][] = array(
                    'token' => $data['token']
                );
            }
            if (!empty($data['regist_type']))
            {
                $conditions['where'][] = array(
                    'regist_type' => $data['regist_type']
                );
            }
            if (isset($data['disable']) && $data['disable'] != '')
            {
                $conditions['where'][] = array(
                    'disable' => $data['disable']
                );
            }
            $this->_response = \Model_User_Activation::find('first', $conditions);
            if ($this->_response == null) { 
                $this->_addError(self::ERROR_CODE_FIELD_NOT_EXIST, 'id');
                return false;
            }
            return $this->result(\Model_User_Activation::error());
        } catch (\Exception $e)
        {
            $this->_exception = $e;
        }
        return false;
    }

}
