<?php

namespace Bus;

/**
 * Get detail Place 
 *
 * @package Bus
 * @created 2015-06-29
 * @version 1.0
 * @author Caolp
 * @copyright Oceanize INC
 */
class Places_DetailForEdit extends BusAbstract {

    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11)
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id'
    );

    /** @var array $_default  field  */
    protected $_default_value = array(
        'language_type' => 1
    );

    /**
     * Call function get_detail() from model Place 
     *
     * @author Caolp
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data) {
        try {
            $this->_response = \Model_Place::get_detail_for_edit($data);
            return $this->result(\Model_Place::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
