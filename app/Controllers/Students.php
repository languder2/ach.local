<?php

namespace App\Controllers;

class Students extends BaseController
{
    public function adminStudents(): string
    {

        $list= $this->db
            ->table('users')
            ->where("role","student")
            ->limit()
            ->get()
            ->getResult();

        $pageContent    = view("Admin/Students/List",[
            "list"              => &$list
        ]);

        return view('Admin/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);
    }
}
