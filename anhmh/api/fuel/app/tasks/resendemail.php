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
 * @run                 php oil refine resendemail
 * @run                 FUEL_ENV=test php oil refine resendemail
 * @run                 FUEL_ENV=production php oil refine resendemail
 * @copyright           Oceanize INC
 */
class ResendEmail {

    public static function run() {
        \LogLib::info('BEGIN [Resend mail] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("BEGIN [Resend mail] " . date('Y-m-d H:i:s') . "\n\n PROCESSING . . . . ! \n");
        $result = \Model_Mail_Send_Log::resendmail();
        Cli::write("Result:\n");
        if (!empty($result)) {
            foreach ($result as $email => $status) {
                Cli::write("{$email} -> {$status}\n");
            }
        } else {
            Cli::write("No Email process.\n");
        }
        \LogLib::info('END [Resend mail] ' . date('Y-m-d H:i:s'), __METHOD__, $result);
        Cli::write("END [Resend mail] " . date('Y-m-d H:i:s') . "\n");
    }

}
