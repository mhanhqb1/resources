<?php

/**
 * <Controller for systems>
 *
 * @package Controller
 * @created 2015-01-14
 * @version 1.0
 * @author truongnn
 * @copyright Oceanize INC
 */

//include(APPPATH . '/classes/lib/aws/aws-autoloader.php'); 

//use Aws\Ses\SesClient;

class Controller_System extends \Controller_App {

    /**
     *  Delete all cache of system
     * 
     * @return boolean 
     */
    public function action_deletecache() {
        return \Bus\Systems_DeleteCache::getInstance()->execute();
    }
    
    /**
     *  Run bacth in \tasks
     * 
     * @return boolean 
     */
    public function action_runbatch() {
        return \Bus\Systems_RunBatch::getInstance()->execute();
    }
    
    /**
     *  Get list processing of server
     * ˙
     * @return boolean 
     */
    public function action_ps() {
        return \Bus\Systems_Ps::getInstance()->execute();
    }    
    
    /**
     *  Cleanup data
     * ˙
     * @return boolean 
     */
    public function action_cleanupdata() {
        return \Bus\Systems_CleanupData::getInstance()->execute();
    }    
   
    /**
     *  Send mail for testing
     * ˙
     * @return boolean 
     */
    public function action_sendmail() {
        return \Bus\Systems_SendMail::getInstance()->execute();
    }    
   
}
