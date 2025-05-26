<?php
// File: public/index.php
// Front controller with CORS headers and route dispatch via Illuminate Router

// CORS setup
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Autoload and bootstrap (Eloquent, router, response factory)
require __DIR__ . '/../src/bootstrap.php';

use App\Controllers\CountryController;
use App\Controllers\UserController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Define routes pointing to controller methods
$router->get('/countries', [CountryController::class, 'index']);
$router->get('/countries/{id}', [CountryController::class, 'show']);

$router->get('/users', [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);

// Fallback for unmatched routes
$router->fallback(function () {
    return new JsonResponse([
        'status'  => 'error',
        'message' => 'Ruta no encontrada',
    ], 404);
});

// Dispatch the request
$request  = Request::createFromGlobals();
$response = $router->dispatch($request);

// Send the HTTP response back to the client
$response->send();
