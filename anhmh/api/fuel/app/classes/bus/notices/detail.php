<?php

namespace Bus;

/**
 * get detail campus
 *
 * @package Bus
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */
class Notices_Detail extends BusAbstract
{
    /** @var array $_required field require */
    protected $_required = array(
        'id',
    );
    /** @var array $_number_format field number */
    protected $_number_format = array(
        'id'
    );

    /**
     * Get detail notice by id.
     *
     * @author truongnn
     * @param array $data Input array.
     * @return array Detail notice.
     */
    public function operateDB($data)
    {
        try {
            $this->_response = \Model_Notice::get_detail($data);
            return $this->result(\Model_Notice::error());
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
