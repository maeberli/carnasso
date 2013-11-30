<?php
$db = require 'config/autoload/local.php';

$dbParams = $db['db'];
$isDevMode = $db['doctrine']['dev'];
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => $dbParams,
            )
        )
    ),
);
