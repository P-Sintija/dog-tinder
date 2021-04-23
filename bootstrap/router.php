<?php

use App\Controllers\DeleteImageController;
use App\Controllers\HistoryController;
use App\Controllers\HomeController;
use App\Controllers\AuthorizationController;
use App\Controllers\ImageRotateController;
use App\Controllers\LikingController;
use App\Controllers\LogoutController;
use App\Controllers\LookingForController;
use App\Controllers\RegistrationController;
use App\Controllers\ImageUploadController;
use App\Controllers\UserHomeController;
use App\Middlewares\AuthMiddleware;


$container = require_once '../bootstrap/container.php';

$middlewares = [
    UserHomeController::class . '@userPage' => [
        AuthMiddleware::class
    ],
    LookingForController::class . '@lookingFor' => [
        AuthMiddleware::class
    ],
    HistoryController::class . '@history' => [
        AuthMiddleware::class
    ]
];


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [HomeController::class, 'homePage']);
    $route->addRoute('GET', '/registration', [RegistrationController::class, 'registrationPage']);
    $route->addRoute('POST', '/submit', [RegistrationController::class, 'submitUser']);
    $route->addRoute('GET', '/auth', [RegistrationController::class, 'registerUser']);
    $route->addRoute('POST', '/login', [AuthorizationController::class, 'authorization']);
    $route->addRoute('GET', '/user/{id:\d+}', [UserHomeController::class, 'userPage']);
    $route->addRoute('GET', '/lookingFor/{id:\d+}', [LookingForController::class, 'lookingFor']);
    $route->addRoute('POST', '/like/{id:\d+}', [LikingController::class, 'like']);
    $route->addRoute('POST', '/dislike/{id:\d+}', [LikingController::class, 'dislike']);
    $route->addRoute('GET', '/history/{id:\d+}', [HistoryController::class, 'history']);
    $route->addRoute('POST', '/logout', [LogoutController::class, 'logout']);
    $route->addRoute('POST', '/upload/{id:\d+}', [ImageUploadController::class, 'upload']);
    $route->addRoute('POST', '/previous/{id:\d+}', [ImageRotateController::class, 'previous']);
    $route->addRoute('POST', '/next/{id:\d+}', [ImageRotateController::class, 'next']);
    $route->addRoute('POST', '/delete/{id:\d+}', [DeleteImageController::class, 'delete']);

});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:

        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;

        $middlewareKey = $controller . '@' . $method;
        $controllerMiddlewares = $middlewares[$middlewareKey] ?? [];

        foreach ($controllerMiddlewares as $controllerMiddleware) {
            (new $controllerMiddleware)->handle($vars);
        }

        echo $container->get($controller)->$method($vars);
        break;
}