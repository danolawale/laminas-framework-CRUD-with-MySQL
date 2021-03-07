<?php

declare(strict_types=1);

namespace Todo;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/todos',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'show' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/todos/:id',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
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
                    'route' => '/todos/new-todo',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
                        'action' => 'new-todo'
                    ],
                ]
            ],
            'store' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/todos/store',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
                        'action' => 'store'
                    ],
                ]
            ],
            'edit' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/todos/:id/edit',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
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
                    'route' => '/todos/:id/:action',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,

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
                    'route' => '/todos/:id/delete',
                    'defaults' => [
                        'controller' => Controller\TodoController::class,
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
            Controller\TodoController::class => Factory\Controller\TodoControllerFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\TodoService::class => Factory\Service\TodoServiceFactory::class
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
            'todo/todo/index'       => __DIR__ . '/../view/todo/index.phtml',
            'todo/todo/show'       => __DIR__ . '/../view/todo/show.phtml',
            'todo/todo/new-todo'       => __DIR__ . '/../view/todo/create.phtml',
            'todo/todo/edit'       => __DIR__ . '/../view/todo/edit.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
