<?php

namespace Bus;

/**
 * Add info for Violation_report
 *
 * @package Bus
 * @created 2015-03-16
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class ViolationReports_All extends BusAbstract {

    /**
     * Call function add() from model Violation_report
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data) {
        try {            
            $this->_response = \Model_Violation_Report::get_all($data);
            return $this->result(\Model_Violation_Report::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
