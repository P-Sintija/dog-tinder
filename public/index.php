<?php


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
use App\Repositories\MySQLImageRepository;
use App\Repositories\MySQLLikingRepository;
use App\Repositories\MySQLUserRepository;
use App\Repositories\UserImageRepository;
use App\Repositories\UserLikingRepository;
use App\Repositories\UserRepository;
use App\Services\AuthorizationService;

use App\Services\HistoryService;
use App\Services\ImageRotateService;
use App\Services\ImageUploadService;
use App\Services\LikingService;

use App\Services\LookingForService;
use App\Services\RegisterUserService;
use App\Services\UserService;
use App\Template\TwigView;
use App\Validations\ImageValidation;
use App\Validations\SubmissionError;
use App\Validations\SubmissionValidation;
use League\Container\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';


session_start();


$container = new Container;

$container->add(HomeController::class, HomeController::class);

$container->add(RegisterUserService::class, RegisterUserService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(RegistrationController::class, RegistrationController::class)
    ->addArguments([RegisterUserService::class, TwigView::class, SubmissionValidation::class]);

$container->add(SubmissionError::class, SubmissionError::class);
$container->add(SubmissionValidation::class, SubmissionValidation::class)
    ->addArguments([UserRepository::class, SubmissionError::class]);

$container->add(AuthorizationService::class, AuthorizationService::class)
    ->addArgument(UserRepository::class);
$container->add(AuthorizationController::class, AuthorizationController::class)
    ->addArgument(AuthorizationService::class);

$container->add(UserService::class, UserService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class]);
$container->add(UserHomeController::class, UserHomeController::class)
    ->addArguments([UserService::class, TwigView::class]);

$container->add(LookingForService::class, LookingForService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(LookingForController::class, LookingForController::class)
    ->addArguments([LookingForService::class, TwigView::class]);

$container->add(LikingService::class, LikingService::class)
    ->addArguments([UserRepository::class, UserLikingRepository::class]);
$container->add(LikingController::class, LikingController::class)
    ->addArgument(LikingService::class);

$container->add(HistoryService::class, HistoryService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(HistoryController::class, HistoryController::class)
    ->addArguments([HistoryService::class, TwigView::class]);

$container->add(LogoutController::class, LogoutController::class);




$container->add(Environment::class, Environment::class)
    ->addArgument(new FilesystemLoader('Views'));
$container->add(TwigView::class,TwigView::class)
    ->addArguments([Environment::class, UserImageRepository::class]);

$container->add(UserRepository::class, MySQLUserRepository::class);
$container->add(UserImageRepository::class, MySQLImageRepository::class);
$container->add(UserLikingRepository::class, MySQLLikingRepository::class);

$container->add(ImageValidation::class,ImageValidation::class);

$container->add(ImageUploadService::class, ImageUploadService::class)
    ->addArgument(UserImageRepository::class);
$container->add(ImageUploadController::class, ImageUploadController::class)
->addArguments([ImageUploadService::class, ImageValidation::class]);

$container->add(ImageRotateService::class, ImageRotateService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class]);
$container->add(ImageRotateController::class, ImageRotateController::class)
    ->addArguments([ImageRotateService::class, TwigView::class]);



$middlewares = [
    UserHomeController::class . '@userPage' => [
        AuthMiddleware::class
    ],
    HistoryController::class .  '@history' => [
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

        foreach ($controllerMiddlewares as $controllerMiddleware){
            (new $controllerMiddleware)->handle($vars);
        }


        $container->get($controller)->$method($vars);
        break;
}