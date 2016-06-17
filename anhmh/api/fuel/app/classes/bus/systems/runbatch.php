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
class Systems_RunBatch extends BusAbstract {

    /**
     * run batch
     *
     * @created 2015-01-14
     * @updated 2015-01-14
     * @access public
     * @author thailh
     * @param $data
     * @return bool
     */
    public function operateDB($data) {
        try {
            /*
             * $data['name'] as below:
             * NewsSitesRss, 
             * PushMessage,
             * Master
             */
            $env = \Fuel::$env;
            if (!empty($data['env'])) {
                $env = $data['env'];
            }
            $taskName = empty($data['name']) ? 'Master' : $data['name'];
            $dir = realpath(DOCROOT . '/..') . DIRECTORY_SEPARATOR;
            $cmd = "php {$dir}oil refine {$taskName}";

            // Check bacth is running
            exec("ps auxwww | grep php", $output);            
            if (!empty($output)) {
                foreach ($output as $proccess) {
                    preg_match('/' . str_replace('/', '\/', $cmd) . "/", $proccess, $match);
                    if (!empty($match[0])) {
                        return true;
                    }
                }
            }

            if ($env != 'development') {
                // if not win os
                if (strncasecmp(PHP_OS, 'WIN', 3) !== 0) {
                    $cmd = "FUEL_ENV={$env} nohup {$cmd} &";
                } else {
                    $cmd = "FUEL_ENV={$env} {$cmd}";
                }
            }
            shell_exec($cmd);
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
