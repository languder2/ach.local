<?php

namespace App\Controllers;

use App\Models\MoodleModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\EmailModel;
use http\Message;

class Users extends BaseController
{
    protected object $users;

    protected int $perPage = 20;

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

        if($this->session->has("isLoggedIn")){
            session()->setFlashdata("account-message",(object)[
                "status"                    => "success",
                "content"                   => "Почта удачно верифицирована",
            ]);
            return redirect()->to(base_url("account"));
        }

        session()->setFlashdata("message",(object)[
            "status"                    => "success",
            "content"                   => "Почта удачно верифицирована. Можете войти в личный кабинет.",
        ]);
        return redirect()->to(base_url("message"));

    }



    public function sdoCreateEmail():void
    {

        /**
        dd(3);
        $email              = $this->request->getPost("email");
        $user               = "";

        $this->users->sdoCreateEmailCURL();
        return  "123";
        /**/
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
    public function test():void
    {
        /**
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
            "name"      => "test",
            "email"     => "languder2@gmail.com",
        ];

        $email          = service('email');

        return "";
        //return  $this->model->translatarate("Проверка Султан С.В.");
        /**/
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
                ->orderBy("id","desc")
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


        $codes          = $this->users->verifiedGenerateCron($user);

        $emailModel     = model(EmailModel::class);

        $emailModel->where([
                        "emailTo"           => $user->email,
                        "theme"             => 'Подтверждение E-mail',
                ])
                ->delete()
        ;

        $emailModel->insert([
                "emailTo"           => $user->email,
                "theme"             => 'Подтверждение E-mail',
                "message"           => view(
                    "Public/Emails/EmailVerification",
                    [
                        "name"                          => $user->name,
                        "patronymic"                    => $user->patronymic,
                        "email"                         => $user->email,
                        "code"                          => $codes->code,
                        "link"                          => base_url("verification/$codes->hash"),
                    ])
        ]);

        $response   = [
            "code"      => 200,
            "action"    => "ShowMessage",
            "message"   => view(
                "Modal/Admin/ResendEmailVerificationSuccess",
                [
                    "user"      => $user,
                ]
            )
        ];

        /**
        $this->db
            ->table('moodle')
            ->insert([
                "email"             => $user->email,
                "login"             => $user->login,
                "role"              => "teacher",
                "muid"              => $arr['id'],
                "pass"              => $pass,
            ]);

        $sql = [
            "emailTo"               => $user->email,
            "theme"                 => "Регистрация в системе дистанционного обучения",
            "message"               => view("Emails/MoodleSignIn",[
                "name"              => "$user->name $user->patronymic",
                "login"             => $user->login,
                "pass"              => $pass,
            ]),
        ];

        $this->db
            ->table('emails')
            ->insert($sql);
/**/


        return response()->setJSON($response);
    }

    public function adminList():string
    {

        $page= $this->request->getGet("page_users")??1;

        $users= $this->users
            ->join("moodle","users.id=moodle.uid","left")
            ->join("students", "students.uid = users.id","left")
            ->select("
                users.*,
                moodle.muid,
                COUNT(students.id) as students
            ")
            ->groupBy("users.id")
        ;
        /**
        GROUP_CONCAT(
            JSON_OBJECT(
                'faculty', faculties.name,
                'department', departments.name,
                'level', levels.name,
                'form', edForms.name,
                'code', specialities.code,
                'speciality', specialities.name,
                'course', students.course,
                'group', students.grp
            )
        ) AS list

        /**/
        if(session()->has("AdminUsersFilter")){
            $filter         = session()->get("AdminUsersFilter");
            $filter         = json_decode($filter);

            $str            = str_replace(" ","%",$filter->search);
            $users->groupStart()
                ->Like("users.email", $str)
                ->orLike("CONCAT(users.surname, ' ', users.name, ' ', users.patronymic)",$str)
                ->orLike("CONCAT(users.name, ' ', users.patronymic, ' ', users.surname)",$str)
                ->groupEnd()
            ;
        }
/**/
        $list       = $users->paginate($this->perPage, "users", $page);
        $list       = $this->users->listPreparing($list);

        if(session()->has("message"))
            $message = session()->get("message");

        $pageContent= view(
            "Admin/Users/List",
            [
                "list"          => $list,
                "pager"         => $users->pager->links("users","admin"),
                "count"         => $users->countAllResults(),
                "filter"        => &$filter,
                "message"       => &$message,
            ]
        );

        return view('Admin/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);

    }

    public function setFilterAdmin():RedirectResponse
    {
        $filter         = (object)[
            "search"    => $this->request->getPost("search")??null
        ];


        if(empty($filter->search))
            session()->remove("AdminUsersFilter");

        else{
            $filter         = json_encode(
                $filter,
                JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT
            );
            session()->set("AdminUsersFilter",$filter);
        }

        return redirect()->to("admin/users");
    }

    public function adminPersonalCard($uid):string|RedirectResponse
    {
        $user                   = $this->users->find($uid);

        $user->roles            = json_decode($user->roles);

        if(!is_array($user->roles))
            $user->roles        = [];

        if(empty($user))
            return redirect()->to(base_url("admin/users"));

        if(session()->has("message"))
            $message = session()->get("message");

        $pageContent = view("Admin/Users/PersonalCard",[
            "user"              => $user,
            "roles"             => [
                "user",
                "student",
                "teacher",
            ],
            "message"           => &$message
        ]);

        return view('Admin/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);
    }

    public function save():RedirectResponse
    {
        $uid                = $this->request->getPost("uid");

        $user               = $this->users->find($uid);

        if(empty($user))
            return redirect()->to(base_url("admin/users"));

        $form               = (object)$this->request->getPost("form");



        $form->roles        = json_encode(
            $form->roles,
            JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT
        );

        if($user->email !== $form->email){


            $cnt = $this->users
                ->where(
                    [
                        "email" => $form->email,
                        "id!="  => $uid,
                    ]
                )->countAllResults();

            if($cnt){
                session()->setFlashdata("message",(object)[
                    "status"                    => "error",
                    "message"                   => "Email занят: $form->email",
                ]);
                return redirect()->back();
            }

            $moodleModel    = model(MoodleModel::class);
            $moodle         = $moodleModel->where("uid",$uid)->first();

            if($moodle !== null){
                $response = $moodleModel->changeEmail($moodle->muid,$form->email);

                if(isset($response['warnings'][0]['message'])){
                    session()->setFlashdata("message",(object)[
                        "status"                    => "error",
                        "message"                   => "Конфликт в Moodle: Email занят: $form->email",
                    ]);

                    return redirect()->back();
                }
            }


            $form->verified     = 0;

            $message            = "<br>Письмо верификации отправлено: $form->email";

            self::ResendVerification($uid);


        }

        $this->users->update(
            $uid,
            $form
        );

        session()->setFlashdata("message",(object)[
            "status"                    => "success",
            "message"                   => "Анкета сохранена: #$uid ".($message??""),
        ]);

        return redirect()->to(base_url("admin/users"));
   }

   public function delete($uid):RedirectResponse
   {
       $userModel       = model(UsersModel::class);
       $moodleModel     = model(MoodleModel::class);

       $user            = $userModel->find($uid);

       if(is_null($user))
           return redirect()->to(base_url("admin/users"));

       $moodle          = $moodleModel->where("uid",$uid)->first();

       if(!is_null($moodle)){
           $moodleModel->deleteUser($moodle->muid);
           $moodleModel->where("uid",$uid)->delete();
       }

       $userModel->where("id",$uid)->delete();

       session()->setFlashdata("message",(object)[
           "status"                    => "success",
           "message"                   => "Пользователь удален #$uid $user->surname $user->name ($user->email)",
       ]);

       return redirect()->to(base_url("admin/users"));
   }

}




