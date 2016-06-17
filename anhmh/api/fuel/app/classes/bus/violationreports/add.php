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
class ViolationReports_Add extends BusAbstract {

    /** @var array $_required field require */
    protected $_required = array(
        'login_user_id'
    );

    /** @var array $_length Length of fields */
    protected $_length = array(
        'login_user_id' => array(1, 11),
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'login_user_id'
    );

    /**
     * Call function add() from model Violation_report
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data) {
        try {
            if (!empty($data['login_user_id'])) {
                $data['user_id'] = $data['login_user_id'];
            }
            $this->_response = \Model_Violation_Report::add($data);
            return $this->result(\Model_Violation_Report::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
