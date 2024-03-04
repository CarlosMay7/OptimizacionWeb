<?php 

require_once __DIR__ . '/../includes/app.php';
include __DIR__ . '/../Router.php';
use MVC\Router;
use Controllers\FeedController;

$router = new Router();

$router->get('/', [FeedController::class, 'index']);
$router->post('/', [FeedController::class, 'agregarFeeds']);

$router->post('/agregar', [FeedController::class, 'agregarFeeds']);

$router->comprobarRutas();