<?php

// CORS para permitir peticiones desde el frontend o Postman
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Autoload de Composer y bootstrap de tu app
require __DIR__ . '/../src/bootstrap.php';

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controllers\CountryController;
use App\Controllers\UserController;

// Ruta raíz para comprobar que el backend responde
$router->get('/', function () {
    return new JsonResponse([
        'status' => 'ok',
        'message' => '✅ Backend funcionando correctamente',
    ]);
});

// Tus otras rutas
$router->get('/countries', [CountryController::class, 'index']);
$router->get('/countries/{id}', [CountryController::class, 'show']);
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);
$router->post('/users/{id}', [UserController::class, 'store']);

// Fallback para rutas no encontradas
$router->fallback(function () {
    return new JsonResponse([
        'status'  => 'error',
        'message' => '❌ Ruta no encontrada',
    ], 404);
});

// Ejecutar
$request = Request::createFromGlobals();
$response = $router->dispatch($request);
$response->send();
