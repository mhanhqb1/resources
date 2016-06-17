<?php
/**
 * Model_Common - Model to operate to Common's functions.
 * 
 * @package Model
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Model_Common extends Model_Abstract {

    public static function disableBook($param) {
        $status = !empty($param['status']) ? $param['status'] : 0;
        $id = !empty($param['id']) ? $param['id'] : 0;
        $book = Model_Book::find($id);
        $book->is_active = $status;
        if (!$book->save()) {
            return false;
        }
        return true;
    }
    /**
     * Function to create trigger.
     *
     * @author thailh 
     * @param array $param Input data.
     * @return string Returns the string.
     */
    public static function trigger($name = '') { 
        $database = DB::query("SELECT DATABASE() AS db_name FROM DUAL;")->execute()->as_array();
        if (empty($database[0])) {
            return false;
        }
        $dbName = $database[0]['db_name'];
        $query = DB::query("select * from information_schema.triggers where trigger_schema = '{$dbName}'");
        $triggers = $query->execute()->as_array();
        $sql = '<pre>';
        foreach ($triggers as $trigger) {
            if (in_array(
                $trigger['EVENT_OBJECT_TABLE'], 
                array('books', 'authors', 'mail_situations', 'news_feed_import_logs_2015_01-27', 'news_feeds_backup_2014_01_23'))) {
                continue;
            }
            /*
             * $trigger['ACTION_TIMING'] = BEFORE / AFTER
             */
            if ($name == '' || strpos($trigger['TRIGGER_NAME'], strtolower($name)) !== false) {
                $sql .= "
                    DROP TRIGGER IF EXISTS `{$trigger['TRIGGER_NAME']}`;
                    CREATE TRIGGER `{$trigger['TRIGGER_NAME']}` {$trigger['ACTION_TIMING']} {$trigger['EVENT_MANIPULATION']} ON `{$trigger['EVENT_OBJECT_TABLE']}` FOR EACH ROW {$trigger['ACTION_STATEMENT']};
                ";                  
            }           
        }
        $sql .= '</pre>';
        return $sql;
    }

}
