<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

use Controllers\AuthController;
use Controllers\GenreController;
use Controllers\MovieController;
use Controllers\SeatController;
use Controllers\TicketController;
use Controllers\UserController;
use DI\ContainerBuilder;
use Middlewares\UserAuthMiddleware;
use PsrJwt\Factory\JwtMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/configs/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);

$app->group('/auth', function (RouteCollectorProxy $group) {
    $group->post('', AuthController::class . ':postLogin');
});

$app->group('', function (RouteCollectorProxy $group) {
    $group->group('/users', function (RouteCollectorProxy $group) {
        $group->post('', UserController::class . ':postUser');
        $group->get('', UserController::class . ':getUsers');

        $group->group('/{user_id:[0-9]+}', function (RouteCollectorProxy $group) {
            $group->get('', UserController::class . ':getUser');
            $group->put('', UserController::class . ':putUser');
            $group->delete('', UserController::class . ':deleteUser');
        });
    });
    $group->group('/tickets', function (RouteCollectorProxy $group) {
        $group->post('', TicketController::class . ':postTicket');
        $group->get('', TicketController::class . ':getTickets');

        $group->group('/{ticket_id:[0-9]+}', function (RouteCollectorProxy $group) {
            $group->get('', TicketController::class . ':getTicket');
            $group->put('', TicketController::class . ':putTicket');
            $group->delete('', TicketController::class . ':deleteTicket');
        });
    });

    $group->group('/genres', function (RouteCollectorProxy $group) {
        $group->get('', GenreController::class . ':getGenres');
    });

    $group->group('/shows', function (RouteCollectorProxy $group) {
        $group->get('', MovieController::class . ':getShows');
        $group->group('/{show_id:[0-9]+}', function (RouteCollectorProxy $group) {
            $group->get('', MovieController::class . ':getShow');
        });
    });

    $group->group('/movies', function (RouteCollectorProxy $group) {
        $group->post('', MovieController::class . ':postMovie');
        $group->get('', MovieController::class . ':getMovies');

        $group->group('/{movie_id:[0-9]+}', function (RouteCollectorProxy $group) {
            $group->get('', MovieController::class . ':getMovie');
            $group->put('', MovieController::class . ':putMovie');
            $group->delete('', MovieController::class . ':deleteMovie');
        });
    });

    $group->group('/seats', function (RouteCollectorProxy $group) {
        $group->get('', SeatController::class . ':getSeats');

        $group->group('/{seat_id:[0-9]+}', function (RouteCollectorProxy $group) {
            $group->put('', SeatController::class . ':putSeat');
        });
    });
})->add(new UserAuthMiddleware())->add(JwtMiddleware::json(base64_decode($container->get('settings')['secret']), 'jwt', ['Authorization failed']));

$app->addBodyParsingMiddleware();
$app->run();
