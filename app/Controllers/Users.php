<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
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
                'form.dataProcessing'           => 'required',
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
                'form.dataProcessing'           =>   [
                    "required"                  =>  'form[dataProcessing]'
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

        $answer= (object)[
            "status"                            => "success",
            "code"                              => "success",
        ];

        return  $this->response->setJSON($answer);
    }

}

