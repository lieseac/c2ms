<?php
use Libraries\Router;
use Libraries\CurrentUser;
use Libraries\Messenger;

$currentUser    = new CurrentUser();
$messenger      = new Messenger();

$router = new Router($currentUser, $messenger);

$router->add('login', ['Controllers\AuthController', 'login']);
$router->add('logout', ['Controllers\AuthController', 'logout']);

// article
$router->add('articles/add', ['Controllers\ArticleController', 'getForm']);
$router->add('articles', ['Controllers\ArticleController', 'getIndex']);

// event
$router->add('events', ['Controllers\EventController', 'getIndex']);
$router->add('events/add', ['Controllers\EventController', 'getForm']);
// user
$router->add('me', ['Controllers\UserController', 'getMe']);
$router->add('users', ['Controllers\UserController', 'getIndex']);
$router->add('users/*', ['Controllers\UserController', 'getShow']);

// topics
$router->add('topics', ['Controllers\TopicController', 'getIndex']);
$router->add('topics/add', ['Controllers\TopicController', 'getForm']);
$router->add('topics/*/update', ['Controllers\TopicController', 'postUpdate']);
$router->add('topics/*/delete', ['Controllers\TopicController', 'getDelete']);

$router->add('*/*', ['Controllers\TopicController', 'route'], function($route){

    $route->add('comment', ['Controllers\CommentController', 'postComment']);
    
    switch($route->module) {
        case 'Models\Article':
            $route->add('update', ['Controllers\ArticleController', 'postUpdate']);
            $route->add('delete', ['Controllers\ArticleController', 'getDelete']);
            $route->add('', ['Controllers\ArticleController', 'getShow']);
            break;
        
        case 'Models\Event':
            $route->add('update', ['Controllers\EventController', 'postUpdate']);
            $route->add('delete', ['Controllers\EventController', 'getDelete']);
            $route->add('attend', ['Controllers\EventController', 'postAttendance']);
            $route->add('', ['Controllers\EventController', 'getShow']);
            break;
    }
});

$router->add('*', ['Controllers\TopicController', 'getShow']);

// home (empty string as path)
$router->add('', ['Controllers\HomeController', 'getIndex']);

$router->dispatch();