<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\Users;
use App\Controllers\Account;
use App\Controllers\Students;
use App\Controllers\Teachers;
use App\Controllers\Modal;
use App\Controllers\Moodle;
use App\Controllers\Test;


/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'base'], function($routes) {
    $routes->group('api/moodle',[], function($routes) {
        $routes->post(  "UserCreate",                           [Moodle::class, 'UserCreate']);
    });

    $routes->group('account',[], function($routes) {
        $routes->get(   "/",                                    [Pages::class, 'account']);
        $routes->post(  "/",                                    [Pages::class, 'account']);
        $routes->post(  "change-info",                          [Account::class, 'changeInfo']);
        $routes->get(   "verification-request",                 [Account::class, 'verificationRequest']);
        $routes->get(   "verification-resend",                  [Account::class, 'verificationResend']);
        $routes->get(   "verification/(:segment)",              [Users::class, 'ssiConfirmLink']);

        $routes->get(   "change-personal",                      [Account::class, 'changePersonal']);
        $routes->get(   "change-education/(:num)",              [Account::class, 'changeEducation']);
        $routes->get(   "add-education",                        [Account::class, 'changeEducation']);
        $routes->post(  "save-education",                       [Account::class, 'saveEducation']);
    });


    $routes->group('modal', [], function($routes) {
        $routes->get(   "admin-verification-resend/(:num)",     [Modal::class, 'VerificationResendAdmin']);
        $routes->get(   "admin-change-moodle-pass/(:num)",      [Modal::class, 'MoodleChangePassRequest']);

    });
    $routes->group('admin', [], function($routes) {
        $routes->get(   "/",                                    [Pages::class, 'adminIndex']);
        $routes->get(   "resend-verification/(:num)",                  [Users::class, 'ResendVerification']);
    });

    $routes->group('admin/students', [], function($routes) {
        $routes->get(   "/",                                    [Students::class, 'adminStudents']);
        $routes->post(  "set-filter",                           [Students::class, 'setFilter']);
    });

    $routes->group('admin/teachers', [], function($routes) {
        $routes->get(   "/",                                    [Teachers::class, 'adminTeachers']);
        $routes->post(  "set-filter",                           [Teachers::class, 'setFilter']);
        $routes->get(   "correct",                              [Teachers::class, 'correct']);
    });

/**/
$routes->group('students', [], function($routes) {
    $routes->post(  "confirm",                                  [Users::class, 'ssiConfirm']);
    $routes->get(   "email_confirm/(:segment)",                 [Users::class, 'ssiConfirmLink']);
});
/**/
    $routes->group("sdo", [], function($routes) {
        $routes->get(   "email",                                   [Users::class, 'sdoCreateEmail']);
    });
/**/
    $routes->match(["get","post"],"/",                          [Pages::class, 'auth']);
    $routes->get('exit',                                        [Users::class, 'exit']);
    $routes->post('signUp',                                     [Users::class, 'signUp']);
    $routes->get('pass',                                        [Users::class, 'pass']);
    $routes->post('authSI',                                     [Users::class, 'authSI']);

    $routes->get('RecoverPassword',                             [Users::class, 'RecoverPassword']);
    $routes->post('RecoverPassword',                            [Users::class, 'RecoverPassword']);
    $routes->get('RecoverPassword/(:segment)',                  [Users::class, 'RecoverPassword']);

    $routes->get('account/change-password',                     [Account::class, 'ChangePassword']);
    $routes->post('account/change-password',                    [Account::class, 'cpProcessing']);

    $routes->get('message',                                     [Pages::class, 'Message']);
    $routes->get("test",                                        [Test::class, 'test']);
//    $routes->get("json",                                        [Test::class, 'json']);
//    $routes->get("moodle",                                      [Test::class, 'moodle']);
//    $routes->get("moodle2",                                      [Test::class, 'moodle2']);
    $routes->get("mailing",                                     [Test::class, 'mailing']);
//    $routes->get("test-email",                                  [Test::class, 'generateEmails']);
//    $routes->get("teachers",                                    [Test::class, 'SITeachers']);
//    $routes->get("students",                                    [Test::class, 'students']);
    $routes->get("report",                                      [Test::class, 'saveXLS']);

    $routes->post("ask-question",                               [Pages::class, 'AskQuestion']);

    $routes->match(["get","post"],"(:any)",                     [Pages::class, 'redirect2main']);
});
