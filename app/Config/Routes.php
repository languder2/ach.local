<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Users;
use App\Controllers\Admin;
use App\Controllers\Students;


/**
 * @var RouteCollection $routes
 */


$routes->get(   "/",                                    [Pages::class, 'faq']);
$routes->get(   'exit',                                 [Users::class, 'exit']);
$routes->post(  'signUp',                               [Users::class, 'signUp']);
$routes->get(   'pass',                                 [Users::class, 'pass']);
$routes->post(  'authSI',                               [Users::class, 'authSI']);
$routes->get(   'RecoverPassword',                      [Users::class, 'RecoverPassword']);
$routes->post(  'RecoverPassword',                      [[Users::class, 'RecoverPassword'],"true"]);



$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get(   "test",                                     [Users::class, 'test']);
    $routes->get(   "account",                                  [Pages::class, 'account']);
});

$routes->get(   "admin",                              [Pages::class, 'adminAuth']);
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get(   "index",                                    [Pages::class, 'adminIndex']);
    $routes->get(   "students",                                 [Students::class, 'adminStudents']);
});


$routes->group('students', [], function($routes) {
    $routes->get(   "",                                         [Users::class, 'ssiStep1']);
    $routes->get(   "signIn",                                   [Users::class, 'ssiStep1']);
    $routes->post(  "signIn",                                   [Users::class, 'ssiProcessingS1']);
    $routes->get(   "email_confirm",                            [Users::class, 'ssiStep3']);
    $routes->post(  "confirm",                                  [Users::class, 'ssiConfirm']);
    $routes->get(   "email_confirm/(:segment)",                 [Users::class, 'ssiConfirmLink']);
    $routes->get(   "step2",                                    [Users::class, 'ssiStep2']);
    $routes->post(  "step2",                                    [Users::class, 'ssiProcessingS2']);
    $routes->get(   "change-data",                              [Users::class, 'ssiChangeData']);
    $routes->get(   "resend-email",                             [Users::class, 'ssiResendEmail']);
    $routes->get(   "success",                                  [Users::class, 'ssiSuccess']);
});

$routes->group("sdo", [], function($routes) {
    $routes->get(   "email",                                   [Users::class, 'sdoCreateEmail']);
});



/**
$routes->group('test', ['filter' => 'myfilter'], function($routes) {
    $routes->get('profile', 'AccountController::profile');
    $routes->get('settings', 'AccountController::settings');
});
/**/