<?php

use Psr\Container\ContainerInterface;
use Services\AuthService;
use Services\GenreService;
use Services\QueryService;
use Services\TicketService;
use Services\UserService;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },
    'database' => function (ContainerInterface $container) {
        $settings = $container->get('settings')['database'];
        return new mysqli($settings['db_host'], $settings['db_username'], $settings['db_password'], $settings['db_name']);
    },
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },
    QueryService::class => function (ContainerInterface $container) {
        return new QueryService($container->get('database'));
    },
    UserService::class => function (ContainerInterface $container) {
        return new UserService($container->get(QueryService::class));
    },
    TicketService::class => function (ContainerInterface $container) {
        return new TicketService($container->get(QueryService::class));
    },
    GenreService::class => function (ContainerInterface $container) {
        return new GenreService($container->get(QueryService::class));
    },
    AuthService::class => function (ContainerInterface $container) {
        return new AuthService($container->get(QueryService::class), $container->get('settings')['secret']);
    }
];
