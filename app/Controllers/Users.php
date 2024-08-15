<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function signUp(): string
    {
        $form= $this->request->getVar('form');

        return  json_encode($form, JSON_UNESCAPED_UNICODE);
    }

}
