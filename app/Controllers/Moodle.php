<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmailModel;
use App\Models\MoodleModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use MoodleRest;

class Moodle extends BaseController
{
    public function UserCreate(): RedirectResponse|string
    {

        $userModel      = model(UsersModel::class);
        $moodleModel    = model(MoodleModel::class);
        $emailModel     = model(EmailModel::class);


        $user           = $userModel->find(session()->get("isLoggedIn")->id);

        $login          = $this->request->getPost("form")['login'];
        $login          = trim(strtolower($login));

        $email          = trim(strtolower($user->email));

        $MoodleRest     = new MoodleRest(
            'https://do.mgu-mlt.ru/webservice/rest/server.php',
            'b6ec48e0a26f33c7dce5418139990d51'
        );

        $pass           = $userModel->generateSecurePassword();

        $func           = "core_user_create_users";

        $params         = [
            "users"     => [
                [
                    "username"          => $login,
                    "firstname"         => $user->name,
                    "lastname"          => $user->surname,
                    "password"          => $pass,
                    "email"             => $email,
                ],
            ]
        ];

        $response       = $MoodleRest->request($func, $params);

        if(isset($response['errorcode']) and $response['errorcode'] === "invalidparameter"){

            $message = str_replace(
                "Email address already exists",
                "Email уже занят",
                $response['debuginfo']
            );

            $message = str_replace(
                "Username already exists",
                "Логин уже занят",
                $response['debuginfo']
            );

            session()->setFlashdata("account-message",(object)[
                "status"                    => "error",
                "content"                   => "$message"
            ]);

            return redirect()->to(base_url("account"));
        }

        $moodleModel->insert(
            [
                "muid"      => $response[0]['id'],
                "uid"       => $user->id,
                "login"     => $response[0]['username'],
                "email"     => $user->email,
                "role"      => "teacher",
                "pass"      => $pass,
            ]
        );

        $emailModel->insert([
            "emailTo"           => $user->email,
            "theme"             => "Регистрация в системе дистанционного обучения",
            "message"           => view(
                "Emails/MoodleSignIn",
                [
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $login,
                    "pass"              => $pass,
                ])
        ]);

        dd($response);


        return " 1";

    }
}
