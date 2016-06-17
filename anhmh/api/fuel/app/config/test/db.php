<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=sv4.evolable-asia.z-hosts.com;dbname=bremen',
			'username'   => 'journal_dev',
			'password'   => 'journal_dev',
		),
	),
);
