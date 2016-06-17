<?php

namespace Bus;

/**
 * get list area
 *
 * @package Bus
 * @created 2015-03-25
 * @version 1.0
 * @author Tran Xuan Khoa
 * @copyright Oceanize INC
 */
class Prefectures_List extends BusAbstract
{
    /** @var array $_number_format field number */
    protected $_number_format = array(
        'page',
        'limit'
    );

    /**
     * call function get_list() from model Prefecture
     *
     * @created 2015-03-25
     * @updated 2015-03-25
     * @access public
     * @author Tran Xuan Khoa
     * @param $data
     * @return array
     * @example
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Prefecture::get_list($data);
            return $this->result(\Model_Prefecture::error());

        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
