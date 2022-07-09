<?php
require_once __DIR__ . '/../includes/app.php';
// ROUTER
use MVC\router;
use Controller\loginController;
$router = new Router();
// HOME
$router->get('/', [LoginController::class, 'home']);
$router->post('/', [LoginController::class, 'home']);
// LOGIN
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
// RECOVER PASSWORD
$router->get('/forgot-password', [LoginController::class, 'forgotPassword']);
$router->post('/forgot-password', [LoginController::class, 'forgotPassword']);
$router->get('/recover-password', [LoginController::class, 'recoverPassword']);
$router->post('/recover-password', [LoginController::class, 'recoverPassword']);
// CREATE ACCOUNT
$router->get('/signup', [LoginController::class, 'signup']);
$router->post('/signup', [LoginController::class, 'signup']);
// CHECK ROUTER
$router->checkRoutes();