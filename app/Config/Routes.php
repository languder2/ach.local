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
use App\Controllers\Correct;
use App\Controllers\Event;
use App\Controllers\Email;


/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'base'], function($routes) {
    $routes->GET('events/results',                         [Event::class, 'showResults']);
});

$routes->group('', ['filter' => 'base'], function($routes) {

    $routes->get(   "change-email",                             [Moodle::class, 'changeEmail']);
    $routes->get(   "correct",                                  [Correct::class, 'moodleRoles']);

    $routes->group('api/moodle',[], function($routes) {
        $routes->post(  "UserCreate",                           [Moodle::class, 'MoodleCreate']);
        $routes->post(  "AdminMoodleCreate",                    [Moodle::class, 'AdminMoodleCreate']);
    });

    $routes->group('account',[], function($routes) {
        $routes->get(   "/",                                    [Pages::class, 'account']);
        $routes->post(  "/",                                    [Pages::class, 'account']);
        $routes->post(  "change-info",                          [Account::class, 'changeInfo']);
        $routes->get(   "verification-request",                 [Account::class, 'verificationRequest']);
        $routes->get(   "verification-resend",                  [Account::class, 'verificationResend']);

        $routes->get(   "change-personal",                      [Account::class, 'changePersonal']);
        $routes->get(   "change-education/(:num)",              [Account::class, 'changeEducation']);
        $routes->get(   "add-education",                        [Account::class, 'changeEducation']);
        $routes->post(  "save-education",                       [Account::class, 'saveEducation']);

        $routes->get(  "moodle-get-new-pass",                   [Moodle::class, 'moodleNewPass']);
    });

    $routes->get(   "verification/(:segment)",                  [Users::class, 'ssiConfirmLink']);

    $routes->group('modal', [], function($routes) {
        $routes->get(   "admin-verification-resend/(:num)",     [Modal::class, 'VerificationResendAdmin']);
        $routes->get(   "admin-moodle-change-pass/(:num)",      [Modal::class, 'MoodleChangePassRequest']);
        $routes->get(   "admin-moodle-create-user/(:num)",      [Modal::class, 'MoodleCreateUserRequest']);
        $routes->get(   "admin-delete-user/(:num)",             [Modal::class, 'DeleteUserRequest']);

    });
    $routes->group('admin', [], function($routes) {
        $routes->get(   "/",                                    [Pages::class, 'adminIndex']);
        $routes->get(   "resend-verification/(:num)",           [Users::class, 'ResendVerification']);
        $routes->get(  "moodle/new-pass/(:num)",                [Moodle::class, 'adminMoodleNewPass']);
    });

    $routes->group('admin/sdo', [], function($routes) {
        $routes->get("get-last-access",                         [Moodle::class, 'getLastAccess']);
//        $routes->get("nagnp",                                   [Moodle::class, 'NotActiveGetNewPass']);
        $routes->get("gets",                                    [Moodle::class, 'gets']);
    });

    $routes->group('admin/users', [], function($routes) {
        $routes->get(   "/",                                    [Users::class, 'adminList']);
        $routes->post(  "set-filter",                           [Users::class, 'setFilterAdmin']);
        $routes->get(  "(:num)",                                [Users::class, 'adminPersonalCard']);
        $routes->get(  "new",                                   [Users::class, 'adminPersonalCard']);
        $routes->post(  "save",                                 [Users::class, 'save']);
        $routes->post(  "create",                               [Users::class, 'create']);
        $routes->get(  "delete/(:num)",                         [Users::class, 'delete']);

//        $routes->GET("check-or-create",                         [Users::class, 'CheckOrCreate']);
    });

    $routes->group('admin/students', [], function($routes) {
        $routes->get(   "/",                                    [Students::class, 'adminStudents']);
        $routes->post(  "set-filter",                           [Students::class, 'setFilter']);
    });

    $routes->group('admin/teachers', [], function($routes) {
        $routes->get(   "/",                                    [Teachers::class, 'adminTeachers']);
        $routes->post(  "set-filter",                           [Teachers::class, 'setFilter']);
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
    $routes->get("report",                                      [Test::class, 'saveXLS']);
    $routes->get("getUser",                                     [Moodle::class, 'getUser']);

    $routes->post("ask-question",                               [Pages::class, 'AskQuestion']);

    $routes->get("log",                                         [Test::class, 'logTest']);

    $routes->get("event/signup",                                [Event::class, 'eventSignupForm']);
    $routes->post("event/signup",                               [Event::class, 'eventSignupSave']);
    $routes->get("event/signup/success",                        [Event::class, 'eventSignupSuccess']);


    $routes->GET("emails/send",                                 [Email::class, 'send']);

    $routes->match(["get","post"],"(:any)",                     [Pages::class, 'redirect2main']);
});

