<?php

namespace Bus;

/**
 * Add or update info for Team
 *
 * @package Bus
 * @created 2015-07-01
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Teams_AddUpdateMultiple extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        
    );

    /**
     * Call function add_update() from model Team
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {            
            $this->_response = \Model_Team::add_update_multiple($data);
            return $this->result(\Model_Team::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
