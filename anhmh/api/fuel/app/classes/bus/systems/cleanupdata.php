<?php

namespace Bus;

/**
 * Cleanup data
 *
 * @package Bus
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */
class Systems_CleanupData extends BusAbstract {

    /** @var array $_required field require */
    protected $_required = array(
        'table_name',
        'column1',
        'column2'
    );
    /**
     * call function delete_data() from model System
     *
     * @author truongnn
     * @param array Input array('table_name', 'column1', 'column2')
     * @return bool
     */
    public function operateDB($data) {
        try {
            \Model_System::cleanupdata($data);
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
