<?php

namespace Bus;

/**
 * Search info user
 *
 * @package Bus
 * @created 2015-06-10
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Users_SearchInfo extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'name'  => array(1, 64),
        'phone' => array(1, 64),
        'email' => array(1, 255)
    );

    /**
     * Call function search_info() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_User::search_info($data);
            return $this->result(\Model_User::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
