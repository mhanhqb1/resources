<?php

namespace Bus;

/**
 * Get list Help (using array count)
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Adminnotices_List extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
       
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit',
        'disable',       
    );

    protected $_date_format = array(
        'date_from' => 'Y-m-d',
        'date_to' => 'Y-m-d'
    );
    
    /**
     * Call function get_list() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin_Notice::get_list($data);
            return $this->result(\Model_Admin_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
