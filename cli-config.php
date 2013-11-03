<?php

$include = array(
    "vendor/doctrine/orm/lib/",
    "vendor/doctrine/dbal/lib/",
    "vendor/doctrine/common/lib/",
);

set_include_path(get_include_path(). PATH_SEPARATOR .implode(PATH_SEPARATOR, $include));

// Setup autoloading
require 'init_autoloader.php';

require_once "bootstrap_doctrine.php";

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));
