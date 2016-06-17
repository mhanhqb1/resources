<?php

namespace Bus;

/**
 * get detail admin
 *
 * @package Bus
 * @created 2014-11-20
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Admins_Detail extends BusAbstract
{
    // check number
    protected $_number_format = array(
        'id'
    );

    // check length
    protected $_length = array(
        'id' => array(1, 11),
        'login_id' => array(0, 40),
        'password' => array(0, 40)
    );

    /**
     * get detail admin by id or login_id
     *
     * @created 2014-11-20
     * @updated 2014-11-20
     * @access public
     * @author Le Tuan Tu
     * @param $data
     * @return bool
     * @example
     */
    public function operateDB($data)
    {
        try {
            if (!empty($data['id'])) {
                $id = $data['id'];
                $this->_response = \Model_Admin::find($id);
                if ($this->_response == null) { 
                     $this->_addError(self::ERROR_CODE_FIELD_NOT_EXIST, 'id', $data['id']);
                    return false;
                }
            } else {
                if (!empty($data['login_id'])) {
                    $conditions['where'][] = array(
                        'login_id' => $data['login_id']
                    );   
                    if (!empty($data['password'])) {
                        $conditions['where'][] = array(
                            'password' => $data['password']
                        );
                    }
                    $this->_response = \Model_Admin::find('first', $conditions);
                    if ($this->_response == null) { 
                        $this->_addError(self::ERROR_CODE_FIELD_NOT_EXIST, 'login_id', $data['login_id']);
                        return false;
                    }
                }                
            }
            return $this->result(\Model_Admin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
