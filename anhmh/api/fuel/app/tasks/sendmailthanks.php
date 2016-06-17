<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\Config;

//use Fuel\Core\Package;

/**
 * Send mail thank you
 *
 * @package             Tasks
 * @create              May 22 2015
 * @version             1.0
 * @author             <Caolp>
 * @run                 php oil refine sendmailthanks
 * @run                 FUEL_ENV=test php oil refine sendmailthanks
 * @run                 FUEL_ENV=production php oil refine sendmailthanks
 * @copyright           Oceanize INC
 */
class SendMailThanks
{
    public static function run()
    {
        \LogLib::info('BEGIN [Send mail Thank You] '.date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("BEGIN [Send mail Thank You] ".date('Y-m-d H:i:s')."\n\n PROCESSING . . . . ! \n");
        $result = \Model_Order::send_mail_thanks();
        Cli::write("Result:\n");
        foreach ($result as $email => $status) {
            Cli::write("{$email} -> {$status}\n");
        }
        \LogLib::info('END [Send mail Thank You] ' .date('Y-m-d H:i:s'), __METHOD__, $result);
        Cli::write("END [Send mail Thank You] ".date('Y-m-d H:i:s')."\n");
    }
}