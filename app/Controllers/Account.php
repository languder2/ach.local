<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Account extends BaseController
{
    protected object $users;
    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function ChangePassword():string|RedirectResponse
    {
        if(session()->has("rp-email"))
            $email          = session()->get("rp-email");

        if($this->session->has("isLoggedIn")){
            $user           = $this->session->get("isLoggedIn");
            $email          = $user->email;
        }

        if(!isset($email))
            return redirect()->to("/");

        $pageContent= view("Public/Account/ChangePassword",[
            "email"         => $email,
            "user"          => &$user
        ]);

        return view('Public/Page',[
            "pageContent" => $pageContent,
        ]);
    }

    public function cpProcessing():RedirectResponse
    {
        if(session()->has("rp-email"))
            $email          = session()->get("rp-email");

        if($this->session->has("isLoggedIn")){
            $user           = $this->session->get("isLoggedIn");
            $email          = $user->email;
        }

        if(!isset($email))
            return redirect()->to("/");

        $form= (object)$this->request->getPost("form");

        if(empty($form->password) || $form->password !== $form->retry){
            return redirect()->to("/");
        }

        $this->db
            ->table("users")
            ->update(
                [
                    "password"          => password_hash($form->password, PASSWORD_DEFAULT),

                ],
                [
                    "email"             => $email
                ]
            );

        $this->db
            ->table("actions")
            ->delete([
                "op"                    => $email,
                "code"                  => "RecoverPassword"
            ]);

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => "Пароль успешно изменен"
        ]);

        $user = $this->db
            ->table("users")
            ->where("email",$email)
            ->get()
            ->getFirstRow();

        if(is_null($user))
            return redirect()->to("/");

        $this->session->set("isLoggedIn",$user);

        return redirect()->to("account");
    }

    public function changeInfo():RedirectResponse
    {
        if($this->session->has("isLoggedIn"))
            $user           = $this->session->get("isLoggedIn");
        else
            return redirect()->to("/");


        $form = (object)$this->request->getPost("form");

        if(isset($form->email) and $form->email !== $user->email){
            $cnt= $this->db
                ->table("users")
                ->where("email",$form->email)
                ->where("id!=",$user->id)
                ->get()
                ->getNumRows();

            if($cnt !== 0){
                session()->setFlashdata("account-message",(object)[
                    "status"                    => "error",
                    "content"                   => "E-mail ".$form->email." занят",
                ]);

                return redirect()->to("account");
            }

            $form->verified = '0';

            $newUser = clone $user;

            $newUser->email = $form->email;

            $this->users->verifiedGenerate($newUser);
        }


        $this->db
            ->table("users")
            ->update(
                (array)$form,
                [
                    "email"     => $user->email
                ]
            );

        $this->users->updateLogged();

        $message= match ($this->request->getPost("type")){
            "personal"          => "Персональные данные сохранены",
            "education"         => "Данные о обучении сохранены",
            default             => null
        };

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => $message,
        ]);

        return redirect()->to("account");
    }


    public function verificationRequest():RedirectResponse
    {

        if(empty($this->user))
            return redirect()->to("/");

        $this->users->verifiedGenerate($this->user);

        return redirect()->to("account");
    }

    public function verificationResend():RedirectResponse
    {
        $this->users->verifiedGenerate($this->user);

        session()->setFlashdata("account-message",(object)[
            "status"                    => "success",
            "content"                   => "Письмо для верификации почты ".$this->user->email." отправлено",
        ]);

        return redirect()->to("account");
    }

}



