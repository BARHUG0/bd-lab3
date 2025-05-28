<?php
// File: src/bootstrap.php
// Bootstraps Eloquent, Routing, Views, and Response Factory

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\CallableDispatcher as ConcreteDispatcher;
use Illuminate\Routing\Contracts\CallableDispatcher;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\FileViewFinder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env if using vlucas/phpdotenv
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad(); // <-- más seguro, no lanza excepción
}

// ----------
// ELOQUENT SETUP
// ----------
$capsule = new Capsule;

// Add database connection using environment variables or custom array
$capsule->addConnection([
    'driver'    => getenv('DB_CONNECTION') ?: 'pgsql',
    'host'      => getenv('DB_HOST') ?: '127.0.0.1',
    'database'  => getenv('DB_DATABASE') ?: 'forge',
    'username'  => getenv('DB_USERNAME') ?: 'forge',
    'password'  => getenv('DB_PASSWORD') ?: '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'port'      => getenv('DB_PORT') ?: '5432',
]);


// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Boot Eloquent ORM
$capsule->bootEloquent();

// 1) Container
$container = new Container;
Container::setInstance($container);

// Bind CallableDispatcher interface to implementation
$container->bind(CallableDispatcher::class, ConcreteDispatcher::class);

// 2) Event Dispatcher
$events = new Dispatcher($container);

// 3) Router
$router = new Router($events, $container);

// 4) Filesystem for views and engines
$filesystem = new Filesystem;

// 5) Engine Resolver and register PHP engine
$resolver = new EngineResolver;
$resolver->register('php', function () use ($filesystem) {
    return new PhpEngine($filesystem);
});

// 6) View Finder pointing to views directory
$finder = new FileViewFinder($filesystem, [__DIR__ . '/views']);

// 7) View Factory
$viewFactory = new ViewFactory($resolver, $finder, $events);

// 8) URL Generator
$currentRequest = HttpRequest::createFromGlobals();
$urlGenerator   = new UrlGenerator(
    $router->getRoutes(),
    $currentRequest
);

// 9) Redirector
$redirector = new Redirector($urlGenerator);

// 10) Response Factory
$responseFactory = new ResponseFactory($viewFactory, $redirector);

// Bind the ResponseFactory to enable response() helper
$container->instance(
    Illuminate\Contracts\Routing\ResponseFactory::class,
    $responseFactory
);
