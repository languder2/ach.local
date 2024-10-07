<?php

namespace App\Controllers;

class Students extends BaseController
{
    protected int $countOnPage = 100;

    public function adminStudents(): string
    {

        $cntAll     = $this->db
            ->table('users')
            ->where("JSON_CONTAINS(roles, '\"student\"', '$')")
            ->countAllResults();

        dd($cntAll);

        $list       = $this->db
            ->table('users')
            ->where("JSON_CONTAINS(roles, '\"student\"', '$')")
            ->orderBy("regdate","DESC")
            ->limit($this->countOnPage,0)
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
