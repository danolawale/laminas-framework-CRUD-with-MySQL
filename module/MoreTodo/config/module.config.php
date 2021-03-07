<?php

declare(strict_types=1);

namespace MoreTodo;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/more/todos',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'show' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/more/todos/:id',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action'     => 'show',

                        'constraints' => [
                            'id' => '/d+'
                        ]
                    ],
                ]
            ],
            'new' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/more/todos/new-todo',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action' => 'new-todo'
                    ],
                ]
            ],
            'store' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/more/todos/store',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action' => 'store'
                    ],
                ]
            ],
            'edit' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/more/todos/:id/edit',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action'     => 'edit',

                        'constraints' => [
                            'id' => '/d+'
                        ]
                    ],
                ]
            ],
            'update' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/more/todos/:id/:action',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,

                        'constraints' => [
                            'id' => '/d+',
                            'action' => '/update|complete'
                        ]
                    ],
                ]
            ],
            'delete' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/more/todos/:id/delete',
                    'defaults' => [
                        'controller' => Controller\MoreTodoController::class,
                        'action'     => 'delete',

                        'constraints' => [
                            'id' => '/d+'
                        ]
                    ],
                ]
            ],

        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\MoreTodoController::class => Factory\Controller\MoreTodoControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            //Service\MoreTodoServiceInterface::class => Factory\Service\MoreTodoServiceFactory::class
            //Service\MoreTodoService::class => ReflectionBasedAbstractFactory::class
        ]
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'         => __DIR__ . '/../view/layout/layout.phtml',
            'more-todo/more-todo/index'       => __DIR__ . '/../view/more-todo/index.phtml',
            'more-todo/more-todo/show'       => __DIR__ . '/../view/more-todo/show.phtml',
            'more-todo/more-todo/new-todo'       => __DIR__ . '/../view/more-todo/create.phtml',
            'more-todo/more-todo/edit'       => __DIR__ . '/../view/more-todo/edit.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
