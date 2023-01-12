<?php

use Psr\Log\LoggerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Tgu\Perminova\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Perminova\Blog\Http\Actions\Likes\CreateLikes;
use Tgu\Perminova\Blog\Http\Actions\Posts\CreatePosts;
use Tgu\Perminova\Blog\Http\Actions\Comments\DeletePosts;
use Tgu\Perminova\Blog\Http\Actions\Users\CreateUser;
use Tgu\Perminova\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Perminova\Blog\Http\ErrorResponse;
use Tgu\Perminova\Blog\Http\Request;
use Tgu\Perminova\Blog\Http\SuccessResponse;
use Tgu\Perminova\Blog\Exceptions\HttpException;
use Tgu\Perminova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Perminova\Blog\Repositories\PostRepository\SqlitePostRepository;
use Tgu\Perminova\Blog\Repositories\UsersRepository\SqliteUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();
var_dump($_SERVER);
die;
$conteiner = require __DIR__ . '/bootstrap.php';
$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));
$logger = $conteiner->get(LoggerInterface::class);
try {
    $path = $request->path();
} catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
} catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
$routes = [
    'GET' => ['/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create'=> CreatePost::class,
        '/comment/create'=> CreateComment::class,
        '/like/create'=> CreateLikes::class,
    ],
];

if (!array_key_exists($path, $routes[$method])) {
    $message = "Route not found: $path $method";
    $logger->warning($message);
    (new ErrorResponse($message))->send();
    return;
}
$actionClassName = $routes[$method][$path];

$action = $conteiner->get($actionClassName);

try {
    $response = $action->handle($request);
    $response->send();
} catch (Exception $exception) {
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
