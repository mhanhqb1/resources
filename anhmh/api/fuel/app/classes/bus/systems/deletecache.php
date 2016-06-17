<?php
namespace Bus;
/**
 * Delete all cache
 *
 * @package Bus
 * @created 2015-06-03
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Systems_DeleteCache extends BusAbstract {

    /**
     * Delete all cache
     *        
     * @author thailh
     * @param $data
     * @return bool
     */
    public function operateDB($data) {
        try {
            $path = \Config::get('cache.path');
            $files = array();
            $files = array_merge($files, glob($path . '*.cache')); // remove cached data
            foreach ($files as $f) {
                if (is_file($f)) {
                    unlink($f);
                }
            }        
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
