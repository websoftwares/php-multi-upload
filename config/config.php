<?php
/**
 * Obviously for demonstrating purposes we can allow this kind of config files in the index.php_ini_loaded_file
 * In real life situations we should move this out of the web root
 * and have some .env file to load in the environment settings
 * or go fancy with injecting in run time the connection configuration)
 */
return [
    'db' => [
        'mysql:dbname=vc4a_upload;host=127.0.0.1',
         'root',
         'root',
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    ]
];
