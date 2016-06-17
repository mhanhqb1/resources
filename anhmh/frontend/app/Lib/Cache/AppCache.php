<?php

/**
 * 
 * Cache for application
 * @package Lib
 * @created 2014-11-25
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class AppCache extends Cache {

    /**
     * Overite method write cache
     *   
     * @author thailvn
     * @param string $key Unique cache key      
     * @param object $value Cache value     
     * @param int $seconds Number of seconds for cache      
     * @return void    
     */
    public static function write($key, $value, $seconds = 0) {
        if (!empty($seconds)) {
            $duration = "+{$seconds} seconds";
            parent::set(array('duration' => $duration));
        }
        parent::write($key, $value);
    }

}
