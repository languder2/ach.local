<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class Modal extends BaseController
{
    protected int $perPage = 30;
    protected UsersModel $users;

    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }
    public function VerificationResendAdmin($uid):ResponseInterface
    {

        $user= $this->users->where("id",$uid)->first();

        if(!$user)
            return response()->setJSON([
                "code"  => 400,
            ]);

        $response = [
            "code"      => 200,
                "html"      => view('Modal/Admin/ResendEmailVerification',["user"=>$user]),
        ];

        return response()->setJSON($response);
    }


}
