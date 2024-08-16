<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index(): string
    {
        return view('Public/Page',[
            "pageContent"       => $pageContent??null
        ]);
    }


}
