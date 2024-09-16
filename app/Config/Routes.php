<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Users;


/**
 * @var RouteCollection $routes
 */


$routes->get(   '/',                                    [Pages::class, 'index']);
$routes->post(  'signUp',                               [Users::class, 'signUp']);
$routes->get(   'pass',                                 [Users::class, 'pass']);


$routes->get(   "admin",                                [Users::class, 'adminPage']);
$routes->get(   "admin/(:any)",                         [Users::class, 'adminPage']);


$routes->group('students', [], function($routes) {
    $routes->get(   "signIn",                                [Users::class, 'studentSignIn']);
    $routes->post(  "signIn",                                [Users::class, 'ssiProcessing']);
    $routes->get(   "email_confirm",                         [Users::class, 'ssiStep2']);
    $routes->post(  "confirm",                               [Users::class, 'ssiConfirm']);
    $routes->get(   "email_confirm/(:segment)",              [Users::class, 'ssiConfirmLink']);
    $routes->get(   "step3",                                 [Users::class, 'ssiStep3']);
    $routes->post(  "step3",                                 [Users::class, 'ssiProcessingS3']);
});





/**
$routes->group('test', ['filter' => 'myfilter'], function($routes) {
    $routes->get('profile', 'AccountController::profile');
    $routes->get('settings', 'AccountController::settings');
});
/**/