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

use App\Validations\ImageValidation;
use App\Validations\SubmissionError;
use App\Validations\SubmissionValidation;

use App\ViewContent\Content;
use League\Container\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$container = new Container;

//////// controllers ////////
$container->add(HomeController::class, HomeController::class)
->addArguments([Content::class, Template::class]);
$container->add(RegistrationController::class, RegistrationController::class)
    ->addArguments([RegisterUserService::class,  SubmissionValidation::class, Content::class, Template::class]);
$container->add(AuthorizationController::class, AuthorizationController::class)
    ->addArguments([AuthorizationService::class, Content::class, Template::class]);
$container->add(UserHomeController::class, UserHomeController::class)
    ->addArguments([UserService::class, Content::class, Template::class]);
$container->add(LookingForController::class, LookingForController::class)
    ->addArguments([LookingForService::class, Content::class, Template::class]);
$container->add(LikingController::class, LikingController::class)
    ->addArgument(LikingService::class);
$container->add(HistoryController::class, HistoryController::class)
    ->addArguments([HistoryService::class, Content::class, Template::class]);
$container->add(LogoutController::class, LogoutController::class);
$container->add(ImageUploadController::class, ImageUploadController::class)
    ->addArguments([ImageUploadService::class, ImageValidation::class]);
$container->add(ImageRotateController::class, ImageRotateController::class)
    ->addArguments([ImageRotateService::class, Content::class, Template::class]);

//////// validations ////////
$container->add(SubmissionError::class, SubmissionError::class);
$container->add(SubmissionValidation::class, SubmissionValidation::class)
    ->addArguments([UserRepository::class, SubmissionError::class]);
$container->add(ImageValidation::class,ImageValidation::class);

//////// services ///////////
$container->add(RegisterUserService::class, RegisterUserService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(AuthorizationService::class, AuthorizationService::class)
    ->addArgument(UserRepository::class);

$container->add(UserService::class, UserService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class]);
$container->add(LookingForService::class, LookingForService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(LikingService::class, LikingService::class)
    ->addArguments([UserRepository::class, UserLikingRepository::class]);
$container->add(HistoryService::class, HistoryService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class, UserLikingRepository::class]);
$container->add(ImageUploadService::class, ImageUploadService::class)
    ->addArgument(UserImageRepository::class);
$container->add(ImageRotateService::class, ImageRotateService::class)
    ->addArguments([UserRepository::class, UserImageRepository::class]);

//////// repositories ///////
$container->add(UserRepository::class, MySQLUserRepository::class);
$container->add(UserImageRepository::class, MySQLImageRepository::class);
$container->add(UserLikingRepository::class, MySQLLikingRepository::class);

//////// view //////////////
$container->add(Template::class, Template::class)
    ->addArgument(Environment::class);
$container->add(Environment::class, Environment::class)
    ->addArgument(new FilesystemLoader('Views'));
$container->add(Content::class,Content::class)
    ->addArgument(UserImageRepository::class);

return $container;
