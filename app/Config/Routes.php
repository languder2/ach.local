<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Users;


/**
 * @var RouteCollection $routes
 */


$routes->get('/',                                       [Pages::class, 'index']);
$routes->post('signUp',                                 [Users::class, 'signUp']);
