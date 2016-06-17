<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

WARNING - 2016-06-07 18:18:23 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:18:23 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:18:23 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:18:23 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:18:23 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Authorization":"Basic YW5obWg6YW5obWg=","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:18:23 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
INFO - 2016-06-07 18:18:25 --> Fuel\Core\Database_PDO_Connection::set_timezone - time_zone
ERROR - 2016-06-07 18:18:26 --> 1146 - SQLSTATE[42S02]: Base table or view not found: 1146 Table 'anhmh.authenticates' doesn't exist with query: "SELECT `id`, `user_id`, `token`, `expire_date`, `regist_type`, `created`, UNIX_TIMESTAMP() AS systime FROM `authenticates` WHERE `user_id` IS null AND `token` = 'Basic YW5obWg6YW5obWg=' LIMIT 1" in C:\xampp\htdocs\vcc\anhmh\api\fuel\core\classes\database\pdo\connection.php on line 290
WARNING - 2016-06-07 18:19:01 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:19:01 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:19:01 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:19:01 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:19:38 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Authorization":"Basic YW5obWg6YW5obWg=","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
WARNING - 2016-06-07 18:22:33 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:22:33 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:22:33 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:22:33 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:22:33 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Authorization":"Basic YW5obWg6YW5obWg=","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:22:33 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
INFO - 2016-06-07 18:22:33 --> Fuel\Core\Database_PDO_Connection::set_timezone - time_zone
WARNING - 2016-06-07 18:22:33 --> Model_Authenticate::check_token - Token does not exist - {"user_id":null,"token":"Basic YW5obWg6YW5obWg="}
WARNING - 2016-06-07 18:22:33 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":401,"error":[{"field":"token","code":401,"message":"Access token is invalid"}]}
WARNING - 2016-06-07 18:22:53 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:22:53 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:22:53 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:22:53 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:22:53 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:22:53 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:22:53 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:23:27 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:23:27 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:23:27 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:23:27 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:23:57 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:23:58 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:24:31 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:25:48 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:25:48 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:25:48 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:25:48 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:26:02 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:26:02 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:26:02 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:26:15 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:26:15 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:26:15 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:26:15 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:26:43 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:26:45 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:29:15 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:29:15 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:29:15 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:29:15 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:29:15 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:29:15 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:29:15 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:30:36 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:30:36 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:30:36 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:30:36 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:30:36 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:30:36 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:30:36 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:30:58 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:30:58 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:30:58 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:30:58 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:30:59 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:30:59 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:30:59 --> Bus\BusAbstract::getResponse - Validation error (400) - {"status":400,"error":[{"field":"auth_date_or_auth_key","code":400,"message":"Invalid parameters"}]}
WARNING - 2016-06-07 18:31:24 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:31:24 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:31:24 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:31:24 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:31:41 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:31:41 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:32:58 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:32:58 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:32:58 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:32:58 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:32:58 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:32:58 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
INFO - 2016-06-07 18:32:59 --> Fuel\Core\Database_PDO_Connection::set_timezone - time_zone
ERROR - 2016-06-07 18:32:59 --> 1146 - SQLSTATE[42S02]: Base table or view not found: 1146 Table 'anhmh.settings' doesn't exist with query: "SELECT `t0`.`id` AS `t0_c0`, `t0`.`name` AS `t0_c1`, `t0`.`description` AS `t0_c2`, `t0`.`data_type` AS `t0_c3`, `t0`.`type` AS `t0_c4`, `t0`.`default_value` AS `t0_c5`, `t0`.`value` AS `t0_c6`, `t0`.`pattern_url_rule` AS `t0_c7`, `t0`.`disable` AS `t0_c8`, `t0`.`created` AS `t0_c9`, `t0`.`updated` AS `t0_c10` FROM `settings` AS `t0` WHERE `t0`.`disable` = 0 AND `t0`.`type` = 'global'" in C:\xampp\htdocs\vcc\anhmh\api\fuel\core\classes\database\pdo\connection.php on line 290
WARNING - 2016-06-07 18:33:13 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:33:13 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:33:13 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:33:13 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:33:31 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:33:32 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
WARNING - 2016-06-07 18:34:51 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:34:51 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:34:51 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:34:51 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:34:51 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:34:51 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
INFO - 2016-06-07 18:34:51 --> Bus\BusAbstract::execute - input: - {"os":"webos","language_type":1}
WARNING - 2016-06-07 18:57:36 --> Fuel\Core\Fuel::init - The configured locale en_US is not installed on your system.
INFO - 2016-06-07 18:57:36 --> Fuel\Core\Request::__construct - Creating a new main Request with URI = "test/list"
INFO - 2016-06-07 18:57:36 --> Fuel\Core\Request::execute - Called
INFO - 2016-06-07 18:57:36 --> Fuel\Core\Request::execute - Setting main Request
INFO - 2016-06-07 18:57:36 --> Bus\BusAbstract::execute - headers: - {"Host":"api.anhmh.localhost","Connection":"keep-alive","Cache-Control":"max-age=0","Upgrade-Insecure-Requests":"1","User-Agent":"Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36","Accept":"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8","Accept-Encoding":"gzip, deflate, sdch","Accept-Language":"vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2"}
INFO - 2016-06-07 18:57:36 --> Bus\BusAbstract::execute - user_agent: - "Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.79 Safari\/537.36"
INFO - 2016-06-07 18:57:36 --> Bus\BusAbstract::execute - input: - {"os":"webos","language_type":1}
