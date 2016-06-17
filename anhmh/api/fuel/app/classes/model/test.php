<?php

class Model_Test extends Model_Abstract {
    
    public static function eQuery($table) {
        if (empty($table)) {
            return false;  
        }       
        $result = DB::list_columns($table);
        return $result;
    }
    
    public static function list_all($param) {
        
        $data['test'] = 'sadadas';
        return $data;
    }

}
