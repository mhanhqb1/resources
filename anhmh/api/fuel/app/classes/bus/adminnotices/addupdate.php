<?php

namespace Bus;

/**
 * Add or update info for Help
 *
 * @package Bus
 * @created 2015-07-08
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Adminnotices_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id' => array(1, 11),       
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',       
        'priority',       
    );
    
    /** @var array $_url_format field url */
    protected $_url_format = array(
        'url',       
    );

    /**
     * Call function add_update() from model Help
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Admin_Notice::add_update($data);
            return $this->result(\Model_Admin_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
