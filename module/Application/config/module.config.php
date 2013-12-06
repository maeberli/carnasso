<?php
namespace Application;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

return array(
    'router' => array(
        'routes' => array(
            'index' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/[:action[/[:year]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'year'     => '[0-9]{4}',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin[/:action]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Admin',
                        'action'     => 'login',
                    ),
                ),
            ),
            'events' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/events[/[:action[/[:year][/[:id]]]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'year'   => '[0-9]{4}',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Events',
                        'action'     => 'index',
                    ),
                ),
            ),
            'events_management' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/events/:action/:id',
                    'constraints' => array(
                        'action' => 'edit|delete',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Events',
                        'action'     => 'manage',
                    ),
                ),
            ),
            'association' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/association[/:action[/:year][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'year'   => '[0-9]{4}',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Association',
                        'action'     => 'index',
                    ),
                ),
            ),
			'association_management' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/association/:action/:id',
                    'constraints' => array(
                        'action' => 'edit|delete',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Association',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => function($sm) {
                return $sm->get('doctrine.authenticationservice.orm_default');
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
            'Application\Controller\Association' => 'Application\Controller\AssociationController',
            'Application\Controller\Admin' => 'Application\Controller\AdminController',
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
    'doctrine' => array(
        'driver' => array(
			__NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
					__DIR__ . '/../src/' . __NAMESPACE__ . '/Model/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
					__NAMESPACE__ . '\Model\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'identity_class' => __NAMESPACE__ . '\Model\Entity\User',
                'identity_property' => 'usrName',
                'credential_property' => 'usrPassword',
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
