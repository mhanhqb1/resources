<?php

namespace Fuel\Tasks;

use Fuel\Core\Cli;

/**
 * Master task
 * RUN BATCH: 
 * php oil refine Master
 * FUEL_ENV=test php oil refine Master
 * FUEL_ENV=production php oil refine Master
 * @author thailh
 */
class Master {

    public static function run($env = 'development') {
        try {           
            $sleep = 10*60;
            set_time_limit(0);            
            $dir = DOCROOT;            
            $cmd = array(
                'SendMailThanks' => "php {$dir}oil refine SendMailThanks",               
                'SendMailReminders' => "php {$dir}oil refine SendMailReminders",               
            );
            if ($env != 'development')
            {
                if (strncasecmp(PHP_OS, 'WIN', 3) !== 0) 
                {
                    $cmd['SendMailThanks'] = "FUEL_ENV={$env} nohup php {$dir}oil refine SendMailThanks &";                           
                    $cmd['SendMailReminders'] = "FUEL_ENV={$env} nohup php {$dir}oil refine SendMailReminders &";                            
                }
                else
                {
                    $cmd['SendMailThanks'] = "FUEL_ENV={$env} php {$dir}oil refine SendMailThanks &";                           
                    $cmd['SendMailReminders'] = "FUEL_ENV={$env} php {$dir}oil refine SendMailReminders &"; 
                }
            }            
            while (true)
            {	
                foreach ($cmd as $name => $c) {
                    \LogLib::info("BEGIN {$name} " . date('Y-m-d H:i'));
                    Cli::write(PHP_EOL . "-> BEGIN {$name} " . date('Y-m-d H:i'));
                    exec($c);                    
                    Cli::write(PHP_EOL . "-> END {$name}  " . date('Y-m-d H:i'));
                    \LogLib::info("END {$name} " . date('Y-m-d H:i'));
                }                
                Cli::write(PHP_EOL . '-> Sleep ' . $sleep . ' seconds ' . date('Y-m-d H:i'));
                sleep($sleep);
            }
        } catch (Exception $ex) {
             \LogLib::error(sprintf("Exception\n"
                            . " - Message : %s\n"
                            . " - Code : %s\n"
                            . " - File : %s\n"
                            . " - Line : %d\n"
                            . " - Stack trace : \n"
                            . "%s", 
                            $ex->getMessage(), 
                            $ex->getCode(), 
                            $ex->getFile(), 
                            $ex->getLine(), 
                            $ex->getTraceAsString()), 
            __METHOD__);
            Cli::write($ex->getMessage());
        }
    }

}
