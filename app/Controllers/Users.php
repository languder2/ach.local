<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use http\Message;

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

        $this->users->verifiedGenerate($user);

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
            $answer["page"]             = base_url("account");
            $answer["email"]            = $email;

            session()->setFlashdata("account-message",(object)[
                "status"                    => "success",
                "content"                   => "Почта удачно верифицирована",
            ]);
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

        if(is_null($action)){
            session()->set("message","Код верификации недействителен или ссылка устарела");
            return redirect()->to("message");
        }

        $this->db
            ->table("actions")
            ->delete(["op"=>$action->op]);

        $this->db
            ->table("users")
            ->update(["verified"=>"1"],["email"=>$action->op]);

        $this->users->updateLogged();

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => "Почта удачно верифицирована",
        ]);

        return redirect()->to("account");
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

        $list= $this->db
            ->table("students")
            ->select("students.*,COUNT(id) as num,id")
            ->groupBy(
                "uid,faculty,department,level,speciality,grp"
            )
            ->orderBy("id","DESC")
            ->get()
            ->getResult();

        foreach($list as $item){
            if($item->num>1) {
                $this->db->table("students")->delete(["id"=>$item->id]);
            }
        }

        dd($list);
        $form= (object)[
            "name"      => "tets",
            "email"     => "languder2@gmail.com",
        ];

        $email          = service('email');

        return "";
        //return  $this->model->translatarate("Проверка Султан С.В., Шевченко, Трищук.? asd");
    }

    public function exit():RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to(route_to("Pages::index"));
    }

    public function RecoverPassword($code = false):ResponseInterface
    {

        if($code){
            $q = $this->db
                ->table("actions")
                ->where([
                    "value"     => $code,
                    "code"      => "RecoverPassword"
                ])
                ->orderBy("time","desc")
                ->get()
                ->getFirstRow()
            ;


            if(is_null($q)){
                session()->set("view","Messages/RecoverPassword/LinkOutdated");
                return redirect()->to(route_to("Pages::Message"));
            }


            session()->set("rp-email",$q->op);

            $user = $this->db
                ->table("users")
                ->where("email",$q->op)
                ->get()
                ->getFirstRow();

            $this->session->set("isLoggedIn",$user);

            return redirect()->to(route_to("Account::ChangePassword"));

        }

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


        /* generate code */
        $code = hash("sha1",microtime(true));

        /* clear old password recover records*/
        $this->db
            ->table("actions")
            ->delete([
                "op"        => $user->email,
                "code"      => "RecoverPassword"
            ]);

        /* add new password recover record*/
        $this->users->setAction("RecoverPassword",$user->email,$code);

        /* generate password recover link */
        $link= base_url(route_to("Users::RecoverPassword")."/$code");

        /* send mail with password recover link */
        $this->model->sendEmail(
            $user->email,
            "Восстановление пароля",
            view(
                "Emails/RecoverPassword",
                [
                    "name"                          => $user->name,
                    "patronymic"                    => $user->patronymic,
                    "email"                         => $user->email,
                    "link"                          => $link,
                ])
        );

        /* send answer */
        $answer = [
            "status"            => "success",
            "message"           => view("Messages/RecoverPassword/MailSend")
        ];

        return  $this->response->setJSON($answer);
    }

    public function ResendVerification($uid):ResponseInterface
    {

        $user= $this->users->where("id",$uid)->first();

        if(!$user)
            return response()->setJSON([
                "code"  => 400,
            ]);


        $this->users->verifiedGenerateCron($user);

        $response   = [
                "code"      => 200,
                "uid"       => $uid,
                "user"      => $user
        ];

        return response()->setJSON($response);
    }


}



