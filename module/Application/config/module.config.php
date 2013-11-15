<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '[/[:action[/[:id]]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'general' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '[/[association[/[:action[/[:year]]]]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'year'     => '[0-9]+', // Could also be an ID
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'events' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/events[/[:action[/[:id]]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Events',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'entityManager' => function($sm) {
                $paths = array("Application\src\Model\Entity");
                $db = require 'config/autoload/local.php';

                // the connection configuration
                $dbParams = $db['db'];
                $isDevMode = $db['doctrine']['dev'];

                $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
                $em = EntityManager::create($dbParams, $config);
                return $em;
            },
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Events' => 'Application\Controller\EventsController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'entity' => 'Application\Controller\Plugin\Entity',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'partial/menu'            => __DIR__ . '/../view/partial/menu.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
