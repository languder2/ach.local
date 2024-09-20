<?php

namespace App\Controllers;

class Pages extends BaseController
{
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
        $user= session()->get("user");

        $pageContent    = view("Public/Account/Base",[
            "user" => $this->user,
        ]);
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




}
