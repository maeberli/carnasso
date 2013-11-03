<?php
use Doctrine\ORM\Tools\Setup;

require_once "Doctrine/ORM/Tools/Setup.php";
Setup::registerAutoloadPEAR();

// Create a simple "default" Doctrine ORM configuration with annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/Application/src/Application/Model/Entity"), $isDevMode);

// get db acces informations
$conf = require __DIR__ . '/config/autoload/local.php';
$conn = $conf['db'];

// obtaining the entity manager
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
