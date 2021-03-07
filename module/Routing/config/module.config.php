<?php

declare(strict_types=1);

namespace Routing;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            "routing" => [
                "type" => Segment::class,
                "options" => [
                    "route" => "/routing[/][:action]",
                    "defaults" => [
                        "controller" => Controller\IndexController::class,
                        "action" => "index"
                    ]
                ]
            ],

            "showAll" => [
                "type" => Segment::class,
                "options" => [
                    "route" => "/routing/items/:action",
                    "defaults" => [
                        "controller" => Controller\IndexController::class,
                        "action" => "show"
                    ]
                ]
            ],
            "single" => [
                "type" => Segment::class,
                "options" => [
                    "route" => "/routing/items/item/:id",
                    "defaults" => [
                        "controller" => Controller\IndexController::class,
                        "action" => "showItem"
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'routing/index/index' => __DIR__ . '/../view/routing/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
