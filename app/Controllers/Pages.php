<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pages extends BaseController
{
    protected UsersModel $users;
    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function faq(): string
    {

        $pageContent = view("Public/FAQ",[]);

        return view('Public/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent,
        ]);
    }
    public function auth(): string|RedirectResponse
    {

        if (session()->has('isLoggedIn')) {
            return redirect()->to('account');
        }


        $form= (object) $this->request->getPost("form");

        if(!empty($form->login) && !empty($form->password)){
            $user       = $this->db
                ->table("users")
                ->where("email",$form->login)
                ->orWhere("login",$form->login)
                ->get()
                ->getFirstRow();


            if(is_null($user)){
                session()->setFlashdata("auth-message",
                    [
                        "status"    => "error",
                        "content"   => "Пользователь не найден"
                    ]
                );
                return redirect()->to("/");
            }

            if(!password_verify($form->password,$user->password)){
                session()->setFlashdata("auth-message",
                    [
                        "status"    => "error",
                        "content"   => "Неверный пароль"
                    ]
                );
                return redirect()->to("/");
            }
            $this->session->set("isLoggedIn",$user);
            return redirect()->to("account");
        }

        if(session()->has("auth-message"))
            $message = (object)session()->get("auth-message");

        $pageContent = view("Public/Account/SignIn",[
            "message"           => &$message,
        ]);

        return view('Public/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent,
        ]);
    }

    public function account(): string
    {
        if(session()->has("account-message"))
            $message            = session()->getFlashdata("account-message");

        $user= $this->db
            ->table("users")
            ->where("id",session()->get("isLoggedIn")->id)
            ->get()
            ->getFirstRow();

        /**
        $faculties      = $this->db
            ->table("faculties")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**
        $departments    = $this->db
            ->table("departments")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**
        $levels         = $this->db
            ->table("levels")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**
        $specialities   = $this->db
            ->table("specialities")
            ->orderBy("code")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

         /**  */

        $user->students = $this->db
            ->table("students")
            ->join("faculties","faculties.id=students.faculty","left")
            ->join("departments","departments.id=students.department","left")
            ->join("levels","levels.id=students.level","left")
            ->join("specialities","specialities.id=students.speciality","left")
            ->select(
                "students.id,
                faculties.name as faculty,
                departments.name as department,
                levels.name as level,
                specialities.name as speciality,
                specialities.code as code,
                students.course, students.grp, students.status,
                students.year_start, students.year_end
                ",
            )
            ->where("uid",$user->id)
            ->get()
            ->getResult();


        if($user->verified === "0")
            $verification = $this->users->getAction("verificationByLink",$this->user->email);

        /*
        $pageContent    = view("Public/Account/Base",[
            "user"              => $this->user,
            "message"           => &$message,
            "faculties"         => &$faculties,
            "departments"       => &$departments,
            "levels"            => &$levels,
            "specialities"      => &$specialities,
            "verification"      => &$verification,
        ]);

        /**/
        $pageContent    = view("Public/Account/Account",[
            "user"              => $user,
            "message"           => &$message,
            "faculties"         => &$faculties,
            "departments"       => &$departments,
            "levels"            => &$levels,
            "specialities"      => &$specialities,
            "verification"      => &$verification,
        ]);

        /**/
        return view('Public/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent,
        ]);
    }

    public function adminIndex(): string
    {
        $pageContent    = view("Admin/Sections");
        return view('Admin/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);
    }
    public function adminAuth(): string
    {
        return view('Public/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);
    }

    public function Message():string|RedirectResponse
    {
        $message= null;

        if(session()->has("view"))
            $message = view(session()->get("view"),[]);

        if(session()->has("message"))
            $message = view(session()->get("message"),[]);


        if(is_null($message))
            return redirect()->to("/");

        return view("Public/Page",[
            "pageContent"       => &$message,
        ]);
    }

}
