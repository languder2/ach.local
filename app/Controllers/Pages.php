<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pages extends BaseController
{
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

    public function account(): string
    {
        if(session()->has("account-message"))
            $message            = session()->getFlashdata("account-message");

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

        if($this->user->verified === "0")
            $verification = $this->users->getAction("verificationByLink",$this->user->email);

        /**/
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
