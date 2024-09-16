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

    public function test():void
    {
    }

    public function adminPage():RedirectResponse
    {
        $this->users->checkAuth();

        /**
        $router = service('router');
        $currentRoute = $router->getMatchedRoute();
        $controller = $router->controllerName();
        $method = $router->methodName();
        /**/

        return redirect()->to(base_url("/test/123/as"));
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
                'form.dataProcessing'           => 'required',
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
                'form.dataProcessing'           =>   [
                    "required"                  =>  'form[dataProcessing]'
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

        $answer= (object)[
            "status"                            => "success",
            "code"                              => "success",
        ];

        return  $this->response->setJSON($answer);
    }

    public function pass():string
    {
        $pass= $this->request->getVar("pass");
        return password_hash($pass,PASSWORD_BCRYPT);
    }

    public function studentSignIn():string
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

    public function ssiProcessing():RedirectResponse|string
    {

        $form= (object)$this->request->getVar('form');

        $this->session->setFlashdata([
            "ssi-form"              => $form
        ]);

        if(!isset($form->email))
            return redirect()->to(route_to("Users::studentSignIn"));

        /**/

        $validation= (object)[
            "rules"     => [
                'form.surname'                  => 'required',
                'form.name'                     => 'required',
                'form.email'                    => 'required|valid_email',
            ],
            "message"   => [
                'form.surname'                  =>   [
                    "required"                  =>  'form[surname]'
                ],
                'form.name'                     =>   [
                    "required"                  =>  'form[name]'
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

            return redirect()->to(route_to("Users::studentSignIn"));
        }

        if($this->users->checkUser("email",$form->email)){
            $this->session->setFlashdata([
                "ssi-message"           => "Email $form->email уже занят",
                "ssi-errors"            => ["form[email]"]
            ]);

            return redirect()->to(route_to("Users::studentSignIn"));
        }

        /* add user */

        $sql= [
            "surname"                           => $form->surname,
            "name"                              => $form->name,
            "patronymic"                        => $form->patronymic,
            "email"                             => $form->email,
            "phone"                             => $form->phone,
            "messenger"                         => $form->messenger,
        ];

        $hash       = $this->users->verificationAdd("verificationByLink",$form->email,null,true);

        $code = rand(100000, 999999);

        $this->users->verificationAdd("verificationByCode",$form->email,$code,true);

        $this->db
            ->table("users")
            ->insert($sql);

        /* mail */
        $email          = service('email');

        $body           = view("Public/Emails/EmailVerification",[
            "name"                          => $form->name,
            "patronymic"                    => $form->patronymic,
            "email"                         => $form->email,
            "code"                          => $code,
            "link"                          => base_url("students/email_confirm/$hash"),
        ]);

        $email->setFrom("no-reply@mgu-mlt.ru","No Reply MelSU");
        $email->setTo($form->email);
        $email->setSubject('Подтверждение E-mail');
        $email->setMessage($body);
        $email->send();

        $this->session->set("ssi-user",$form);
        $this->session->set("ssi-email-confirm",$code);

        return redirect()->to(route_to("Users::ssiStep2"));
    }

    public function ssiStep2($code= null):string
    {
        if($this->session->has("ssi-user"))
            $user           = $this->session->get("ssi-user");

        if($this->session->has("ssi-email-confirm"))
            $code           = $this->session->get("ssi-email-confirm");


        $pageContent= view("Public/Templates/Students/SignIn/Step2",[
            "user"                      => $user??null,
            "code"                      => $code??null,
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
            $answer["page"]             = base_url(route_to("Users::ssiStep3"));
            $answer["email"]            = $email;
        }
        else
            $answer["status"]           = "error";

        return $this->response->setJSON($answer);
    }

    public function ssiStep3():string
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

    public function ssiProcessingS3():string
    {
        $form           = $this->request->getPost("form");
        $email          = $this->request->getPost("email");

        $this->db
            ->table("users")
            ->update($form,["email"=>$email]);

        $pageContent= view("Public/Templates/Students/SignIn/Success",[
            "email"                     => $email,
        ]);


        return view("Public/Templates/Students/Page",[
            "pageContent"               => $pageContent
        ]);
    }

}



