<?php

App::uses('AppComponent', 'Controller/Component');
App::uses('Validation', 'Utility');

/**
 * 
 * some common methods
 * @package Controller
 * @created 2014-11-26 
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class CommonComponent extends AppComponent {

    /** @var array $components Use components */
    public $components = array('Session', 'Auth', 'RequestHandler');

    /**
     * Set flash success message
     *   
     * @author thailvn
     * @param string $message Success message
     * @return void
     */
    public function setFlashSuccessMessage($message) {
        $message = "<i class=\"fa fa-check\"></i>{$message}";
        $this->Session->setFlash(
            $message, 'default', array('class' => 'alert alert-success alert-dismissable')
        );
    }

    public function mapError($errors, $mapErrors = array(), $parse = false) {
        if (!empty($mapErrors)) {            
            foreach ($mapErrors as $field => $error) {                
                if (isset($errors[$field])) {
                    $err = array();
                    foreach ($error as $key => $msg) {  
                        if (isset($errors[$field][$key])) {
                            $err[$key] = $msg;
                        }
                    }
                    $errors[$field] = $err;
                }
            }            
        }
        if ($parse !== false) {
            return $this->parseArrayMessage($errors, $parse);
        }
        return $errors;
    }
    
    /**
     * Set flash error message
     *    
     * @author thailvn
     * @param array $errors API error
     * @param array $mapErrors ADM error
     * @return void
     */
    public function setFlashErrorMessage($errors, $mapErrors = array()) {
        if (!empty($mapErrors)) {            
            foreach ($mapErrors as $field => $error) {                
                if (isset($errors[$field])) {
                    $err = array();
                    foreach ($error as $key => $msg) {  
                        if (isset($errors[$field][$key])) {
                            $err[$key] = $msg;
                        }
                    }
                    $errors[$field] = $err;
                }
            }
        }
        $message = "<i class=\"fa fa-check\"></i>{$this->parseArrayMessage($errors)}";
        $this->Session->setFlash(
            $message, 'default', array('class' => 'alert alert-warning alert-dismissable')
        );
    }

    /**
     * Parse message array to cms's format
     *     
     * @author thailvn     
     * @param array $arrayMessage List message
     * @param string $sep Seperate messages
     * @return string html message
     */
    public function parseArrayMessage($arrayMessage, $sep = '<br/>') {
        $html = "<span class=\"fa fa-ban\"></span>";
        $html = '';
        if (empty($arrayMessage)) {
            return '';
        }
        if (is_string($arrayMessage)) {
            $html .= $arrayMessage;
            return $html;
        }
        $result = array();
        foreach ($arrayMessage as $message) {
            if (empty($message)) {
                continue;
            }
            if (is_array($message)) {
                foreach ($message as $value) {
                    $result[] = $value;
                }
            } else {
                $result[] = $message;
            }
        }
        $html .= implode($sep, $result);
        return $html;
    }

    /**
     * Get file info when form to be submited
     *    
     * @author thailvn    
     * @param string $field Field name
     * @return array File info
     */
    public function getFile($field) {
        if (empty($_FILES['data']['name'])) {
            return false;
        }
        if (empty($field) OR $field === '') {
            return false;
        }
        $exploded = explode('.', $field);
        if (count($exploded) !== 2) {
            return false;
        }
        list ($model, $value) = $exploded;
        $file['name'] = $_FILES['data']['name'][$model][$value];
        $file['type'] = $_FILES['data']['type'][$model][$value];
        $file['tmp_name'] = $_FILES['data']['tmp_name'][$model][$value];
        $file['error'] = $_FILES['data']['error'][$model][$value];
        $file['size'] = $_FILES['data']['size'][$model][$value];
        return $file;
    }

    /**
     * Create message to write log
     *     
     * @author thailvn
     * @param string $message    
     * @param array|object $data Data to write log
     * @return string Message
     */
    public function getLogMessage($message, $data = array()) {
        $arrayMessage[] = $message;
        if (!empty($data)) {
            $arrayMessage[] = $data;
        }
        return $this->parseArrayMessage($arrayMessage, '\n');
    }

    /**
     * Get string ramdom
     *    
     * @author thailvn
     * @param int $length Length of random string  
     * @param string $chars Chars for random string
     * @return string Random string 
     */
    function stringRandom($length = 5, $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $intCount = 0;
        $result = '';
        do {
            $result .= substr($chars, rand(0, strlen($chars) - 1), 1);
            $intCount++;
        } while ($intCount < $length);
        return $result;
    }

    /**
     * Convert array to key/value
     *    
     * @author thailvn
     * @param array $arr 2D input array
     * @param string $key Field key
     * @param string $value Field value
     * @return array
     */
    public static function arrayKeyValue($arr, $key, $value) {
        $result = array();
        if ($arr) {
            foreach ($arr as $item) {
                $result[$item[$key]] = $item[$value];
            }
        }
        return $result;
    }

    /**
     * Convert array to key/value array
     *    
     * @author thailvn
     * @param array $arr 2D input array
     * @param string $key Field key  
     * @return array  
     */
    public static function arrayKeyValues($arr, $key) {
        $result = array();
        if ($arr) {
            foreach ($arr as $item) {
                $result[$item[$key]] = $item;
            }
        }
        return $result;
    }

    /**
     * Filter record by find value
     *    
     * @author thailvn
     * @param array $arr 2D input array
     * @param string $field Field name
     * @param $findValue Find value
     * @return array  
     */
    public function arrayFilter($arr, $field, $findValue) {
        $result = array();
        if ($arr) {
            foreach ($arr as $key => $item) {
                if ($item[$field] == $findValue) {
                    $result[] = $item;
                }
            }
        }
        return $result;
    }

    /**
     * Convert array to key array/value
     *    
     * @author thailvn
     * @param array $arr 2D input array
     * @param array $arr_key List keys
     * @param string $rootKey Root key
     * @return array  
     */
    public static function arrayKeyArrayValues($arr, $arr_key, $rootKey) {
        $result = array();
        if ($arr) {
            foreach ($arr as $item) {
                foreach ($arr_key as $itemKey) {
                    $result[$item[$rootKey]][$itemKey] = $item[$itemKey];
                }
            }
        }
        return $result;
    }
   
    /**
     * Truncate string
     *    
     * @author thailvn
     * @param string $text Input string
     * @param int $length Length
     * @param object $options See more String::truncate    
     * @return string  
     */
    public function truncate($text, $length = 100, $options = array()) {
        return String::truncate($text, $length, $options);
    }

    /**
     * Get thumb image url
     *     
     * @author thailvn
     * @param string $fileName File name
     * @param string $size Thumb size     
     * @return string Thumb image url  
     */
    public function thumb($fileName, $size = null) {
        if (!is_string($fileName) && $fileName != '') {
            return '';
        }
        if (Validation::url($fileName)) {
            return $fileName;
        }
        if (empty($size)) {
            return $fileName;
        }
        $image = explode('.', $fileName);
        if (count($image) < 2) {
            return '';
        }
        $fileName = sprintf($image[0], '_' . $size) . '.' . $image[1];
        return $fileName;
    }

    /**
     * Date format for application
     *    
     * @author thailvn
     * @param int $time Input DateTime        
     * @return string Date
     */
    public function dateFormat($time = null, $onlyDate = false) {
        if (empty($time) || !is_numeric($time)) {
            return false;
        }
        if($onlyDate == true){
        	return date('Y年m月d日', $time);
        }        
        $minuteAgo = ceil((time() - $time) / 60);
        if ($minuteAgo > 0 && $minuteAgo < 60) {
            return str_pad($minuteAgo, 2, '0', STR_PAD_LEFT) . "分前";
        } elseif ($minuteAgo > 0 && $minuteAgo < 24 * 60) {
            return str_pad(ceil($minuteAgo / 60), 2, '0', STR_PAD_LEFT) . "時間前";
        }
        return date('Y年m月d日', $time);
    }

    /**
     * Date time format for application
     *    
     * @author thailvn
     * @param int $time Input DateTime         
     * @return string DateTime
     */
    public function dateTimeFormat($time = null) {
        if (empty($time)) {
            return false;
        }
        return date('Y-m-d H:i', $time);
    }

    /**
     * Handle exception base on error array of API
     *    
     * @author thailvn
     * @param array $errors
     * @throws NotFoundException
     * @return void
     */
    public function handleException($errors) {
        if (!empty($errors)) {
            foreach ($errors as $error) {
                switch (key($error)) {                    
                    case '1010':  // not exist error  
                    case '1002':  // length is invalid 
                    case '1012':  // must contain a valid number                         
                        AppLog::info("Validation error API", __METHOD__, $errors);
                        throw new NotFoundException($error[key($error)], 404);
                }
            }
        }
    }
    
    /**
     * Array date for chart
     *   
     * @author thailvn
     * @param array $arr   
     * @param string $field Date field name    
     * @return array
     */
    public function arrayDateForChart($arr, $field) {
        if (empty($arr)) {
            return array();
        }
        foreach ($arr as &$row) {
            if (!isset($row[$field])) {
                continue;
            }
            if (date('Y') == date('Y', strtotime($row[$field]))) {
                $row[$field] = date('m/d', strtotime($row[$field]));
            } else {
                $row[$field] = date('y/m/d', strtotime($row[$field]));
            }
        }
        unset($row);
        return $arr;
    }
    
    /**
     * Delete cache after disable
     *    
     * @author thailvn
     * @param string $controller Controller name         
     * @return void
     */
    public function deleteCacheAfterDisable($controller = '') {
        switch ($controller) {
            case 'newssites':
            case 'newsfeeds':
                AppCache::delete(Configure::read('tags_all')->key);
                AppCache::delete(Configure::read('news_sites_all')->key);
                break;    
            default:                
        }
    }

}
