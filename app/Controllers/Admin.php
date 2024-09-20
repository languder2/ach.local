<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {

        dd(333);

        return view('Public/Page',[
            "pageContent"       => $pageContent??null
        ]);
    }


}
