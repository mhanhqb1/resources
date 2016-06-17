<?php

namespace Bus;

/**
 * Add and update info for User
 *
 * @package Bus
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Test_List extends BusAbstract
{
    /**
     * Call function add_update() from model User
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Test::list_all($data);
            return $this->result(\Model_Test::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
