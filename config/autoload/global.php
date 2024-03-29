<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
	'db' => [
        'adapters' => [
            'loja-adapter' => [
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=db_loja_simples;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
                'username' => 'root',
                'password' => '',
            ],
            /*
            'adm-adapter' => [
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=adm;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
                'username' => 'root',
                'password' => '',
            ],
            */
        ],
        'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
    ],
];
