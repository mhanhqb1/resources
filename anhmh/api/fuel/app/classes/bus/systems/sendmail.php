<?php

namespace Bus;

/**
 * run batch
 *
 * @package Bus
 * @created 2015-01-14
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Systems_SendMail extends BusAbstract {
   
    public function operateDB($data) {
        try {            
            \Lib\Email::sendTest($data);
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
