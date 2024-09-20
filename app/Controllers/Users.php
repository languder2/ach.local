<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Users extends BaseController
{
    protected object $users;
    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function signUp(): ResponseInterface
    {

        $form= (object)$this->request->getVar('form');

        $validation= (object)[
            "rules"     => [
                'form.surname'                  => 'required',
                'form.name'                     => 'required',
                'form.patronymic'               => 'required',
                'form.email'                    => 'required|valid_email',
                'form.password'                 => 'required|matches[form.retry]',
                'form.retry'                    => 'required|matches[form.password]',
                'form.agreement'                => 'required',
            ],
            "message"   => [
                'form.surname'                  =>   [
                    "required"                  =>  'form[surname]'
                ],
                'form.name'                     =>   [
                    "required"                  =>  'form[name]'
                ],
                'form.patronymic'               =>   [
                    "required"                  =>  'form[patronymic]'
                ],
                'form.email'                    =>   [
                    "required"                  =>  'form[email]',
                    "valid_email"               =>  'form[email]'
                ],
                'form.password'                 =>   [
                    "required"                  =>  'form[password]',
                    "matches"                   =>  'form[password]',
                ],
                'form.retry'                    =>   [
                    "required"                  =>  'form[retry]',
                    "matches"                   =>  'form[retry]',
                ],
                'form.agreement'                =>   [
                    "required"                  =>  'form[agreement]'
                ],
            ]
        ];

        $validation->status = $this->validate($validation->rules,$validation->message);

        if(!$validation->status){
            $answer= (object)[
                "status"                        => "errors",
                "code"                          => "noValidate",
                "message"                       => "Заполните поля",
                "errors"                        => array_values($this->validator->getErrors())
            ];

            return  $this->response->setJSON($answer);
        }

        $isset= $this->db
            ->table("users")
            ->where("email",$form->email)
            ->get()
            ->getNumRows();

        if($isset){
            $answer= (object)[
                "status"                        => "error",
                "code"                          => "emailOccupied",
                "message"                       => "E-mail $form->email уже занят",
            ];
            return  $this->response->setJSON($answer);
        }

        $sql= [
            "surname"                           => $form->surname,
            "name"                              => $form->name,
            "patronymic"                        => $form->patronymic,
            "email"                             => $form->email,
            "password"                          => password_hash($form->password,PASSWORD_BCRYPT),
        ];

        $this->db
            ->table("users")
            ->insert($sql);

        $user = $this->db
            ->table("users")
            ->where("email",$form->email)
            ->get()
            ->getFirstRow();

        $this->session->set("isLoggedIn",$user);

        $this->users->verifiedGenerate($user,false);

        $answer= (object)[
            "status"                => "success",
            "code"                  => "success",
            "user"                  => $user,
            "page"                  => base_url(route_to("Pages::account")),
        ];

        return  $this->response->setJSON($answer);
    }

    public function pass():string
    {
        $pass= $this->request->getVar("pass");
        return password_hash($pass,PASSWORD_BCRYPT);
    }

    public function ssiStep1():string
    {

        if($this->session->has("ssi-form"))
            $form       = $this->session->get("ssi-form");

        if($this->session->has("ssi-message"))
            $message    = $this->session->get("ssi-message");

        if($this->session->has("ssi-errors"))
            $errors    = $this->session->get("ssi-errors");

        $pageContent= view("Public/Templates/Students/SignIn/Step1",[
            "form"                      => $form??null,
            "message"                   => $message??null,
            "errors"                    => $errors??[],
        ]);


        return view("Public/Templates/Students/Page",[
            "pageContent"               => $pageContent
        ]);
    }

    public function ssiProcessingS1():RedirectResponse|string
    {

        $form= (object)$this->request->getVar('form');

        $this->session->setFlashdata([
            "ssi-form"              => $form
        ]);

        if(!isset($form->email))
            return redirect()->to(route_to("Users::ssiStep1"));

        /**/

        $validation= (object)[
            "rules"     => [
                'form.surname'                  => 'required',
                'form.name'                     => 'required',
                'form.email'                    => 'required|valid_email',
                'form.password'                 => 'required|matches[form.confirm]',
                'form.confirm'                  => 'required|matches[form.password]',
            ],
            "message"   => [
                'form.surname'                  =>   [
                    "required"                  =>  'form[surname]'
                ],
                'form.name'                     =>   [
                    "required"                  =>  'form[name]'
                ],
                'form.password'                 =>   [
                    "required"                  =>  'form[password]'
                ],
                'form.confirm'                  =>   [
                    "required"                  =>  'form[confirm]'
                ],
                'form.email'                    =>   [
                    "required"                  =>  'form[email]',
                    "valid_email"               =>  'form[email]',
                ],
            ]
        ];

        $validation->status = $this->validate($validation->rules,$validation->message);

        if(!$validation->status){

            $this->session->setFlashdata([
                "ssi-message"           => "Заполните обязательные поля",
                "ssi-errors"            => array_values($this->validator->getErrors())
            ]);

            return redirect()->to(route_to("Users::ssiStep1"));
        }

        if($this->users->checkUser("email",$form->email)){
            $this->session->setFlashdata([
                "ssi-message"           => "Email $form->email уже занят",
                "ssi-errors"            => ["form[email]"]
            ]);

            return redirect()->to(route_to("Users::ssiStep1"));
        }

        /* add user */

        $sql= [
            "surname"                           => $form->surname,
            "name"                              => $form->name,
            "patronymic"                        => $form->patronymic,
            "email"                             => $form->email,
            "phone"                             => $form->phone,
            "role"                              => "student",
            "password"                          => password_hash($form->password,PASSWORD_BCRYPT),
            "tmp"                               => $form->confirm,
        ];

        /**/
        $this->db
            ->table("users")
            ->insert($sql);

        /**/
        $this->session->set("ssi-user",$form);

        return redirect()->to(route_to("Users::ssiStep2"));
    }

    public function ssiStep2():string
    {
        if($this->session->has("ssi-form"))
            $form       = $this->session->get("ssi-form");

        if($this->session->has("ssi-message"))
            $message    = $this->session->get("ssi-message");

        if($this->session->has("ssi-errors"))
            $errors    = $this->session->get("ssi-errors");


        /**/
        $faculties      = $this->db
            ->table("faculties")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**/
        $departments    = $this->db
            ->table("departments")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**/
        $levels         = $this->db
            ->table("levels")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**/
        $specialities   = $this->db
            ->table("specialities")
            ->orderBy("code")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;


        /**/
        if($this->session->has("ssi-user"))
            $user           = $this->session->get("ssi-user");

        /**/
        $pageContent= view("Public/Templates/Students/SignIn/Step3",[
            "user"                      => $user??(object)[],
            "form"                      => $form??null,
            "message"                   => $message??null,
            "errors"                    => $errors??[],
            "faculties"                 => $faculties,
            "departments"               => $departments,
            "levels"                    => $levels,
            "specialities"              => $specialities,
        ]);


        return view("Public/Templates/Students/Page",[
            "pageContent"               => $pageContent
        ]);
    }

    public function ssiProcessingS2():RedirectResponse
    {
        $form           = $this->request->getPost("form");

        if($this->session->has("ssi-user")){
            $user           = $this->session->get("ssi-user");
            $email          = $user->email;
            $this->users->verifiedGenerate($user);
        }
        else
            $email          = $this->request->getPost("email");

        if(empty($form) or empty($email))
            return redirect()->back();

        $this->db
                ->table("users")
                ->update($form,["email"=>$email]);

        return redirect()->to(route_to("Users::ssiStep3"));
    }

    public function ssiStep3($code= null):string|RedirectResponse
    {
        if($this->session->has("ssi-user"))
            $user           = $this->session->get("ssi-user");
        else
            return redirect()->to(route_to("Users::ssiStep1"));

        if($this->session->has("ssi-email-confirm"))
            $code           = $this->session->get("ssi-email-confirm");

        $verified= $this->db
            ->table("users")
            ->where([
                "email"             => $user->email,
                "verified"          => "1"
            ])
            ->get()
            ->getNumRows();

        if($verified)
            return redirect()->to(route_to("Users::ssiStep3"));

        $pageContent= view("Public/Templates/Students/SignIn/Step2",[
            "user"                      => $user??null,
            "code"                      => $code??null,
        ]);

        return view("Public/Templates/Students/Page",[
            "pageContent"               => $pageContent
        ]);
    }

    public function ssiSuccess():string
    {
        if($this->session->has("ssi-user"))
            $user           = $this->session->get("ssi-user");


        $pageContent= view("Public/Templates/Students/SignIn/Success",[
            "email"                     => $user->email??null,
        ]);

        return view("Public/Templates/Students/Page",[
            "pageContent"               => $pageContent
        ]);
    }
    public function ssiConfirm():ResponseInterface
    {
        $code1              = $this->session->get("ssi-email-confirm");
        $code2              = implode('',$this->request->getVar('code'));
        $answer= [
            "code1"         => $code1,
            "code2"         => $code2
        ];

        if($code1 == $code2){
            $email= $this->request->getVar('email');

            /**/
            $this->db
                ->table("actions")
                ->delete(["op"=>$email]);

            $this->db
                ->table("users")
                ->update(["verified"=>"1"],["email"=>$email]);
            /**/
            $answer["status"]           = "success";
            $answer["page"]             = base_url(route_to("Users::ssiSuccess"));
            $answer["email"]            = $email;
        }
        else
            $answer["status"]           = "error";




        return $this->response->setJSON($answer);
    }

    public function ssiConfirmLink($code):RedirectResponse
    {
        $action= $this->db
            ->table("actions")
            ->where([
                "code"              => "verificationByLink",
                "value"             => esc($code)
            ])
            ->get()
            ->getFirstRow()
        ;

        if(is_null($action))
            return redirect()->to(route_to("Users::ssiConfirmError"));

        $this->db
            ->table("actions")
            ->delete(["op"=>$action->op]);

        $this->db
            ->table("users")
            ->update(["verified"=>"1"],["email"=>$action->op]);

        return redirect()->to(route_to("Users::ssiSuccess"));
    }

    public function ssiChangeData():RedirectResponse
    {
        $user           = $this->session->get("ssi-user");

        $this->db
            ->table("users")
            ->delete(["email"=>$user->email]);

        $this->db
            ->table("actions")
            ->delete(["op"=>$user->email]);

        $this->session->set("ssi-form",$user);

        return redirect()->to(route_to("Users::ssiStep1"));
    }

    public function ssiResendEmail():ResponseInterface
    {

        if($this->session->has("ssi-user")){

            $form           = $this->session->get("ssi-user");

            $user=          $this->db
                                ->table("users")
                                ->where("email",$form->email)
                                ->get()
                                ->getFirstRow();


            if(is_null($user))
                return $this->response->setJSON([
                    "status"                => "error",
                    "page"                  => base_url(route_to("Users::ssiStep1")),
                ]);

            if($user->verified === "1")
                return $this->response->setJSON([
                    "status"                => "error",
                    "page"                  => base_url(route_to("Users::ssiProcessingS3")),
                ]);

            $this->users->verifiedGenerate($user);

            $answer= [
                "status"                    => "success",
                "counter"                   => 180,
            ];
        }
        else{
            $answer= [
                "status"    => "error",
                "page"      => base_url(route_to("Users::ssiStep1")),
            ];

        }

        return $this->response->setJSON($answer);
    }

    public function sdoCreateEmail():string
    {

        dd(3);
        $email              = $this->request->getPost("email");
        $user               = "";

        $this->users->sdoCreateEmailCURL();
        return  "123";
    }

    public function authSI():ResponseInterface
    {
        $form= (object) $this->request->getPost("form");


        if(!$form->login || !$form->password)
            return $this->response->setJSON([
                "status"    => "error",
            ]);

        $user       = $this->db
                        ->table("users")
                        ->where("email",$form->login)
                        ->orWhere("login",$form->login)
                        ->get()
                        ->getFirstRow();

        if(is_null($user))
            return $this->response->setJSON([
                "status"    => "error",
                "message"   => "Пользователь не найден"
            ]);


        if(!password_verify($form->password,$user->password))
            return $this->response->setJSON([
                "status"    => "error",
                "message"   => "Неверный пароль"
            ]);

        $this->session->set("isLoggedIn",$user);

        $answer     = [
            "status"        => "success",
            "page"          => base_url(route_to("Pages::account")),
        ];

        return $this->response->setJSON($answer);
    }
    public function test():string
    {
        return  $this->model->translatarate("Проверка Султан С.В., Шевченко, Трищук.? asd");
    }

    public function exit():RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to(route_to("Pages::index"));
    }

    public function RecoverPassword($processing = false):ResponseInterface
    {

        $form = (object) $this->request->getVar("form");

        $user = $this->db
            ->table("users")
            ->where("email",$form->email)
            ->get()
            ->getFirstRow();

        if(is_null($user))
            return  $this->response->setJSON([
                "status"        => "error",
                "message"       => "Пользователь не найден",
            ]);

        $answer = [
            "processing"        => $processing,
            "form"              => $form,
            "user"              => &$user,
            "status"            => "success",
            "message"           => "Ссылка для восстановления пароля отправлена Вам на почту!<br>
                                    Она действительна в течение суток"
        ];

        return  $this->response->setJSON($answer);
    }


}



