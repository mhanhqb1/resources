<?php

namespace Bus;

/**
 * Get config for mobile
 *
 * @package Bus
 * @created 2015-06-16
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Mobile_Config_Index extends BusAbstract
{
    /**
     * Get config to mobile
     *
     * @author Le Tuan Tu
     * @param array $data Input data
     * @return bool Success or otherwise
     */
    public function operateDB($data)
    {
        try {
            $this->_response = array(
                'violation_reports' => \Config::get('violation_reports'),
                'teams_section' => \Config::get('teams_section'),
            );
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }
}
