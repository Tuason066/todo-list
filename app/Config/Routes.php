<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->post('/create', 'HomeController::create');
$routes->get('/getTodos', 'HomeController::getTodos');
$routes->post('/getTodoById/(:segment)', 'HomeController::getTodoById/$1');
$routes->post('/deleteTodoById/(:segment)', 'HomeController::deleteTodoById/$1');
$routes->post('/editTodoById', 'HomeController::editTodoById');
