<?php

namespace Bus;

/**
 * Get all Admins (without array count)
 *
 * @package Bus
 * @created 2015-04-02
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Admins_All extends BusAbstract
{   
    /** @var array $_required field require */
    protected $_required = array(
        'admin_type',
        'disable'
    );
    /** @var array $_length Length of fields */
    protected $_length = array(
        'admin_type'=>1,
        'disable' => 1
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'disable',
        'admin_type'
    );

    /**
     * Call function get_all() from model Admin
     *
     * @author Hoang Gia Thong
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin::get_all($data);
            return $this->result(\Model_Admin::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
