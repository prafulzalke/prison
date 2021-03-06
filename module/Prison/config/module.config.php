<?php
include_once('constants.php');

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Prison\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

            'api' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex' => '/api/(?P<projectId>\d+)/store/',
                    'spec' => '/api/%projectId%/store/',
                    'defaults' => array(
                        'controller' => 'Prison\Controller\Api',
                        'action' => 'store',
                    )
                ),
            ),

            'prison' => require_once('routes.config.php'),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            'Prison\Collector\View' => 'Prison\Collector\ViewCollector',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Prison\Controller\Index' => 'Prison\Controller\IndexController',
            'Prison\Controller\Api' => 'Prison\Controller\ApiController',
            'Prison\Controller\Team' => 'Prison\Controller\TeamController',
            'Prison\Controller\Project' => 'Prison\Controller\ProjectController',
            'Prison\Controller\Key' => 'Prison\Controller\KeyController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.twig',
            'prison/index/index'      => __DIR__ . '/../view/prison/index/index.twig',
            'zfcuser/login'           => __DIR__ . '/../view/prison/user/login.twig',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            'Prison_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Prison/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Prison\Entity' => 'Prison_driver'
                )
            )
        )
    ),

    'log' => array(
        'Log\Prison' => array(
            'writers' => array(
                array(
                    'name' => 'stream',
                    'priority' => 1000,
                    'options' => array(
                        'stream' => 'data/logs/prison.log',
                    ),
                ),
            ),
        ),
    ),
    'prison' => array(
        'platforms' => $PLATFORM_LIST,
        'reserved_team_slugs' => $RESERVED_TEAM_SLUGS,
    )
);
