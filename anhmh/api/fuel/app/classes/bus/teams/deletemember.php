<?php

namespace Bus;

/**
 * Delete Team's member
 *
 * @package Bus
 * @created 2016-03-08
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Teams_Deletemember extends BusAbstract {
    
    /** @var array $_required field require */
    protected $_required = array(
        'team_id',
        'user_ids'
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'team_id'
    );

    /**
     * Call function disable() from model Team
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Team::deletemember($data);
            return $this->result(\Model_Team::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
