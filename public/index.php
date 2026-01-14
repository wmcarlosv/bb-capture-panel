<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use Dotenv\Dotenv;

// Configure local session path to avoid permission issues
$sessionPath = __DIR__ . '/../writable/sessions';
if (!file_exists($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
ini_set('session.save_path', $sessionPath);
session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();

// Auth Routes
$router->get('/', 'AuthController@loginForm');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@forgotPasswordForm'); // TODO
$router->post('/forgot-password', 'AuthController@sendResetLink'); // TODO

// Dashboard
$router->get('/dashboard', 'DashboardController@index');

// Users
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/edit/{id}', 'UserController@edit');
$router->post('/users/update/{id}', 'UserController@update');
$router->post('/users/delete/{id}', 'UserController@delete');

// Customers UI (Read Only)
$router->get('/customers', 'CustomerController@index');

// Customers API
$router->get('/api/customers', 'ApiApiCustomerController@index'); // Wait, router logic adds namespace prefix.
// My Router logic: if (strpos($controller, 'Api') === 0) { $controller = "App\\Controllers\\Api\\{$controller}"; }
// So passing 'ApiCustomerController@index' becomes App\Controllers\Api\ApiCustomerController -> Correct.

$router->get('/api/customers', 'ApiCustomerController@index');
$router->post('/api/customers', 'ApiCustomerController@store');
$router->get('/api/customers/{id}', 'ApiCustomerController@show');
$router->put('/api/customers/{id}', 'ApiCustomerController@update');
$router->delete('/api/customers/{id}', 'ApiCustomerController@delete');

// Profile
$router->get('/profile', 'ProfileController@index');
$router->post('/profile', 'ProfileController@update');

// Customers (Optional or part of future? Prompt mentions table but not explicit CRUD in UI reqs, but implied by "project")
// Adding basic placeholder routes if needed, but sticking to prompt reqs:
// "dashboard con inbofox, tablas etc" ... "crud completo de usuarios" ... "pagina de perfil".
// It doesn't explicitly say "Customers CRUD" but it defines the table. I'll focus on Users first.

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
