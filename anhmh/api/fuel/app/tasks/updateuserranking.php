<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;

/**
 * Update User ranking
 *
 * @package             Tasks
 * @create              Aug 13 2015
 * @version             1.0
 * @author              CaoLP
 * @run                 php oil refine updateuserpoint
 * @run                 FUEL_ENV=test php oil refine updateuserpoint
 * @run                 FUEL_ENV=production php oil refine updateuserpoint
 * @copyright           Oceanize INC
 */
class Updateuserranking {
    
    private static $lock_filename = 'tasks_updateuserranking.tmp';// KienNH 2016/06/07
    
    public function __construct(){
        date_default_timezone_set('Asia/Tokyo');
    }
    
    public static function run() {
        // KienNH 2016/06/07: Check lock
        $check_lock = \Lib\Util::checkTaskLock(self::$lock_filename);
        if ($check_lock) {
            \LogLib::info('BREAK [Update user ranking] ' . date('Y-m-d H:i:s'), __METHOD__, array());
            Cli::write("BREAK [Update user ranking] " . date('Y-m-d H:i:s'));
            return false;
        }
        
        ini_set('memory_limit', -1);// KienNH 2016/06/07
        
        \LogLib::info('BEGIN [Update user ranking] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write('BEGIN [Update user ranking] ' . date('Y-m-d H:i:s') . "\n\nPROCESSING . . . . ! \n");
        
        $items = \Model_User_Point_Get_Total_Ranking::rebuild();
        Cli::write('Rebuild ' . $items . " items\n");
        
        \LogLib::info('END [Update user ranking] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write('END [Update user ranking] ' . date('Y-m-d H:i:s') . "\n");
        
        \Lib\Util::deleteTaskLock(self::$lock_filename);// KienNH 2016/06/07
    }

}
