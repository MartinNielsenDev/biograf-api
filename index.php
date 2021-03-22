<?php

use Controllers\GenreController;
use Controllers\SeatController;
use Controllers\UserController;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/configs/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);

//$app->add(new ResponseRequestMiddleware());

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('', UserController::class . ':postUser');
    $group->get('', UserController::class . ':getUsers');

    $group->group('/{user_id:[0-9]+}', function (RouteCollectorProxy $group) {
        $group->get('', UserController::class . ':getUser');
        $group->put('', UserController::class . ':putUser');
        $group->delete('', UserController::class . ':deleteUser');
    });
});

$app->group('/genres', function (RouteCollectorProxy $group) {
    $group->get('', GenreController::class . ':getGenres');
});

$app->group('/seats', function (RouteCollectorProxy $group) {
    $group->get('', SeatController::class . ':getSeats');

    $group->group('/{seat_id:[0-9]+}', function (RouteCollectorProxy $group) {
        $group->put('', SeatController::class . ':putSeat');
    });
});

$app->addBodyParsingMiddleware();
$app->run();
