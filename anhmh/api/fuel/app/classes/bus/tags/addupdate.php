<?php

namespace Bus;

/**
 * Add info for Tag
 *
 * @package Bus
 * @created 2015-03-20
 * @version 1.0
 * @author Hoang Gia Thong
 * @copyright Oceanize INC
 */
class Tags_AddUpdate extends BusAbstract
{
    /** @var array $_length Length of fields */
    protected $_length = array(
        'id'     => array(1, 11),
        'name' => array(1, 128),       
    );

    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id',     
    );

    /**
     * Call function add_update() from model Tag
     *
     * @author Hoang Gia Thong
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Tag::add_update($data);
            return $this->result(\Model_Tag::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
