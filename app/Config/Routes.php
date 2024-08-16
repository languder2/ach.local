<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Users;


/**
 * @var RouteCollection $routes
 */


$routes->get('/',                           [Pages::class, 'index']);
$routes->post('signUp',                     [Users::class, 'signUp']);


/**
$routes->group('test', ['filter' => 'myfilter'], function($routes) {
    $routes->get('profile', 'AccountController::profile');
    $routes->get('settings', 'AccountController::settings');
});
/**/