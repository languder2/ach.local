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
    public function MoodleCreate(): RedirectResponse|string
    {

        $userModel      = model(UsersModel::class);
        $moodleModel    = model(MoodleModel::class);
        $emailModel     = model(EmailModel::class);


        $user           = $userModel->find(session()->get("isLoggedIn")->id);

        $login          = $this->request->getPost("form")['login'];
        $user->login    = trim(strtolower($login));
        $user->email    = trim(strtolower($user->email));
        $user->pass     = $userModel->generateSecurePassword();

        $response       = $moodleModel->CreateUser($user);

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

        $moodleSQL  = [
            "muid"      => $response[0]['id'],
            "uid"       => $user->id,
            "login"     => $user->login,
            "email"     => $user->email,
            "role"      => "teacher",
            "pass"      => $user->pass,
        ];

        $cnt     = $moodleModel->where("uid", $user->id)->countAllResults();

        if($cnt)
            $moodleModel->where("uid", $user->id)->update($moodleSQL);
        else
            $moodleModel->insert($moodleSQL);

        $emailModel->where([
                    "emailTo"           => $user->email,
                    "theme"             => "Регистрация в системе дистанционного обучения",
                ])
            ->delete();

        $emailModel->insert([
            "emailTo"           => $user->email,
            "theme"             => "Регистрация в системе дистанционного обучения",
            "message"           => view(
                "Emails/MoodleSignIn",
                [
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $user->login,
                    "pass"              => $user->pass,
                ])
        ]);

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => "Аккаунт создан. Параметры входа отправлены на почту: $user->email",
        ]);

        return redirect()->back();

    }
    public function AdminMoodleCreate(): ResponseInterface
    {
        $form           = (object)$this->request->getPost("form");

        $userModel      = model(UsersModel::class);
        $moodleModel    = model(MoodleModel::class);
        $emailModel     = model(EmailModel::class);

        $user           = $userModel->find($form->uid);

        $user->login    = trim(strtolower($form->login));
        $user->email    = trim(strtolower($user->email));
        $user->pass     = $userModel->generateSecurePassword();

        $response       = $moodleModel->CreateUser($user);

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

            return response()->setJSON([
                "code"          => 400,
                "message"      => $message
            ]);
        }

        $moodleSQL  = [
            "muid"      => $response[0]['id'],
            "uid"       => $user->id,
            "login"     => $user->login,
            "email"     => $user->email,
            "role"      => "teacher",
            "pass"      => $user->pass,
        ];

        $cnt     = $moodleModel->where("uid", $user->id)->countAllResults();

        if($cnt)
            $moodleModel->where("uid", $user->id)->update($moodleSQL);
        else
            $moodleModel->insert($moodleSQL);

        $emailModel->where([
                    "emailTo"           => $user->email,
                    "theme"             => "Регистрация в системе дистанционного обучения",
                ])
            ->delete();

        $emailModel->insert([
            "emailTo"           => $user->email,
            "theme"             => "Регистрация в системе дистанционного обучения",
            "message"           => view(
                "Emails/MoodleSignIn",
                [
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $user->login,
                    "pass"              => $user->pass,
                ])
        ]);

        return response()->setJSON([
                "code"          => 200,
                "message"          => view('Modal/Admin/MoodleCreateUserSuccess',[
                    "user"      => $user,
                ]),
        ]);
    }



    function moodleNewPass():RedirectResponse|string
    {
        $userModel      = model(UsersModel::class);
        $moodleModel    = model(MoodleModel::class);
        $emailModel     = model(EmailModel::class);

        $user           = $userModel->find(session()->get("isLoggedIn")->id);
        if(empty($user))
            return redirect()->back();

        $moodle         = $moodleModel->where("uid",$user->id)->first();
        if(empty($moodle))
            return redirect()->back();

        $pass           = $userModel->generateSecurePassword();

        $response       = $moodleModel->changePass($moodle->muid,$pass);

        if(isset($response['warnings'][0]['message'])){
            session()->setFlashdata("account-message",(object)[
                "status"                    => "error",
                "content"                   => $response['warnings'][0]['message'],
            ]);

            return redirect()->to(base_url("account"));
        }

        $emailModel->insert([
            "emailTo"           => $user->email,
            "theme"             => "СДО: смена пароля",
            "message"           => view(
                "Emails/MoodleChangePass",
                [
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $moodle->login,
                    "pass"              => $pass,
                ])
        ]);

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => "Пароль сменен и выслан на email: $user->email",
        ]);

        return  redirect()->to(base_url("account"));
    }
    function adminMoodleNewPass($uid):RedirectResponse|string
    {

        $userModel      = model(UsersModel::class);
        $moodleModel    = model(MoodleModel::class);
        $emailModel     = model(EmailModel::class);

        $user           = $userModel->find($uid);
        if(empty($user))
            return redirect()->to(base_url("admin/users"));


        $moodle         = $moodleModel->where("uid",$user->id)->first();
        if(empty($moodle))
            return redirect()->to(base_url("admin/users"));

        $pass           = $userModel->generateSecurePassword();

        $response       = $moodleModel->changePass($moodle->muid,$pass);

        if(isset($response['warnings'][0]['message'])){
            session()->setFlashdata("message",(object)[
                "status"                    => "error",
                "message"                   => $response['warnings'][0]['message'],
            ]);

            return redirect()->to(base_url("admin/users"));
        }

        $emailModel->insert([
            "emailTo"           => $user->email,
            "theme"             => "СДО: смена пароля",
            "message"           => view(
                "Emails/MoodleChangePass",
                [
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $moodle->login,
                    "pass"              => $pass,
                ])
        ]);

        session()->setFlashdata("message",(object)[
            "status"                    => "success",
            "message"                   => "Пароль сменен и выслан на email: $user->email",
        ]);

        return  redirect()->to(base_url("admin/users"));
    }

    public function changeEmail()
    {
        $moodleModel    = model(MoodleModel::class);
        $moodleModel->changeEmail(421,"languder6@ya.ru");

    }


}
