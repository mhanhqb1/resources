<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;

/**
 * Send mail thank you
 *
 * @package             Tasks
 * @create              May 22 2015
 * @version             1.0
 * @author             <Tuancd>
 * @run                 php oil refine sendmailreminders
 * @run                 FUEL_ENV=test php oil refine sendmailreminders
 * @run                 FUEL_ENV=production php oil refine sendmailreminders
 * @copyright           Oceanize INC
 */
class SendMailReminders {

    public static function run() {
        \LogLib::info('BEGIN [Send mail reminder] '.date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("BEGIN [Send mail reminder] ".date('Y-m-d H:i:s')."\n\n PROCESSING . . . . ! \n");
        $result = \Model_Order::send_mail_reminders();
        Cli::write("Result:\n");
        foreach ($result as $email => $status) {
            Cli::write("{$email} -> {$status}\n");
        }
        \LogLib::info('END [Send mail reminder] ' .date('Y-m-d H:i:s'), __METHOD__, $result);
        Cli::write("END [Send mail reminder] ".date('Y-m-d H:i:s')."\n");
    }

}
