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
class Systems_Ps extends BusAbstract {

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
        try 
        {  
            $id = !empty($data['id']) ? $data['id'] : '';
            if (!empty($id)) {
                $result = array();
                $pids = explode(',', $id);
                foreach ($pids as $pid) {
                    system("kill -9 {$pid}", $output);
                    if (!$output) {
                        $result[] = 'OK';
                    } else {
                        self::_addError(self::ERROR_CODE_DENIED_ERROR, 'id', "Can not kill process {$pid}");                        
                        return false;                        
                    }
                }                
                $this->_response = $result; 
                return true;
            }            
            $search = !empty($data['search']) ? $data['search'] : '';            
            if (!empty($data['all'])) {
                if (!empty($search)) {
                    exec("ps auxwww | grep {$search} | ", $output);
                } else {
                    exec("ps auxwww", $output);
                }
            } else {
                if (!empty($search)) {
                    exec("ps auxwww | grep php | grep {$search} | ", $output);
                } else {
                    exec("ps auxwww | grep php", $output);
                }
            }
            $result = array();
            if ($output) {                
                foreach ($output as $proccess) {
                     preg_match("/(\d+)/", $proccess, $match);
                     if (!empty($match[0])) {
                        $result[] = array(
                            'id' => $match[0],
                            'name' => $proccess
                        );
                     }
                }
            }
            $this->_response = $result;            
            return true;
        } catch (\Exception $e) {
            $this->_exception = $e;
        }
        return false;
    }

}
