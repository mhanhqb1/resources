<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\Config;

include(VENDORPATH . 'php-imap/__autoload.php');
use PhpImap\Mailbox as ImapMailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;
use PhpImap\ParseMail;

/**
 * Import orders from Hot Pepper Service
 *
 * @package             Tasks
 * @create              May 15 2015
 * @version             1.0
 * @author             <Caolp>
 * @run                 php oil refine hpordersimport
 * @run                 FUEL_ENV=test php oil refine hpordersimport
 * @run                 FUEL_ENV=production php oil refine hpordersimport
 * @copyright           Oceanize INC
 */
class HPOrdersImport {

    public static function run() {
        \LogLib::info('BEGIN [Get mail data from Hot Pepper] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("BEGIN [PARSE MAIL HOT PEPPER] ".date('Y-m-d H:i:s')." PROCESSING \n\n . . . . ! \n");
        // Configure your imap mailboxes
        $mailboxes = Config::get('hot_pepper_mailboxes');
        $from = $mailboxes['from_email'];
        $craw_time = date('d-M-Y', strtotime("-1 days"));
        $connection = $mailboxes['connection'];
        $configKey = array(
            'shop_name' => 'shop_name',
            'is_cancel' => 'is_cancel',
            '■予約番号' => 'hp_order_code',
            '■氏名' => 'user_name',
            'kana' => 'kana',
            '■来店日時' => 'reservation_date',
            '■指名スタッフ' => 'nailist_name',
            '■合計金額' => 'total_price',
            '■ご要望・ご相談' => 'request',
            'created' => 'created'
        );
        $conf = $mailboxes[$connection];
        $mailbox = new ImapMailbox(
                $conf['mailbox'], $conf['username'], $conf['password'], __DIR__
        );
        $parseMail = new ParseMail();
        $mailsIds = $mailbox->searchMailBox("SINCE {$craw_time} FROM {$from}");
        if (!$mailsIds) {
            \LogLib::warning('[PARSE MAIL] Mailbox is empty', __METHOD__, $conf);
            Cli::write('[PARSE MAIL] Mailbox is empty\n');
            Cli::write('END [Get mail data from Hot Pepper]\n');
            die;
        }
        $mailParsed = array();
        foreach ($mailsIds as $mailId) {
            Cli::write("[PARSE MAIL] BEGIN parse -> mail_id: {$mailId} \n");
            $mail = $mailbox->getMail($mailId);
            $mailParsed[] = $parseMail->parse_mail($mail->textPlain, $mailId);
            Cli::write("[PARSE MAIL] END parse -> mail_id: {$mailId} \n");
        }

        $hpOrders = array();
        foreach ($mailParsed as $maildata) {
            $hpOrder = array();
            foreach ($maildata as $key => $value) {
                $k = trim($key);
                if (isset($configKey[$k])) {
                    $field = $configKey[$k];
                    $hpOrder[$field] = $value;
                    if (!empty($value)) {
                        switch ($field) {
                            case 'user_name':
                                $nameParsed = $parseMail->parseName($value);
                                $hpOrder['user_name'] = !empty($nameParsed[1]) ? $nameParsed[1] : '';
                                $hpOrder['kana'] = !empty($nameParsed[2]) ? $nameParsed[2] : '';
                                break;
                            case 'total_price':
                                $hpOrder[$field] = $parseMail->parseMoney($value);
                                break;
                            case 'reservation_date':
                            case 'created':
                                $hpOrder[$field] = $parseMail->parseDate($value);
                                break;
                        }
                    }
                }
            }
            if (empty($hpOrder['hp_order_code'])) {
                \LogLib::warning('[PARSE MAIL] hp_order_code does not exists ', __METHOD__, $hpOrder);
                continue;
            }
            $hpOrders[$hpOrder['hp_order_code']] = $hpOrder;
        }
        Cli::write("Result:\n");
        $importedResult = \Model_Order::importHpOrders($hpOrders);
        if (!empty($importedResult)) {
            foreach ($importedResult as $hpOrderCode => $status) {
                Cli::write("{$hpOrderCode} -> {$status}\n");
            }
        } else {
            Cli::write("All HpOrders have already imported\n");
        }
        \LogLib::info('END [Get mail data from Hot Pepper] ' . date('Y-m-d H:i:s'), __METHOD__, array());
        Cli::write("END [PARSE MAIL HOT PEPPER] ".date('Y-m-d H:i:s')."\n");
        exit;
    }

}
