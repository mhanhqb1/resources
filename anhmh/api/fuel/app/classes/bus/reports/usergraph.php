<?php

namespace Bus;

/**
 * get general report
 *
 * @package Bus
 * @created 2016-05-13
 * @version 1.0
 * @author Anhmh
 * @copyright Oceanize INC
 */
class Reports_Usergraph extends BusAbstract
{
        
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Report::get_user_report($data);
            return $this->result(\Model_Report::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
