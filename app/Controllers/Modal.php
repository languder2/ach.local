<?php
namespace App\Controllers;

use App\Models\MoodleModel;
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

    public function MoodleChangePassRequest($uid):ResponseInterface
    {

        $user       = $this->users->find($uid);

        $response = [
            "code"              => 200,
                "html"          => view('Modal/Admin/MoodleChangePassRequest',[
                    "user"      => $user,
                ]),
        ];

        return response()->setJSON($response);
    }

    public function MoodleCreateUserRequest($uid):ResponseInterface
    {

        $moodleModel = model(MoodleModel::class);

        $user       = $this->users->where("id",$uid)->first();

        $login      = substr($user->email,0,stripos($user->email,"@"));

        $cnt        = $moodleModel->where("login",$login)->countAllResults();

        if($cnt)
            $login  = '';

        if(!$user)
            return response()->setJSON([
                "code"          => 400,
            ]);

        $response = [
            "code"              => 200,
            "html"          => view('Modal/Admin/MoodleCreateUserRequest',[
                "user"      => $user,
                "login"     => $login,
            ]),
        ];

        return response()->setJSON($response);
    }

    public function DeleteUserRequest($uid):ResponseInterface
    {

        $moodleModel = model(MoodleModel::class);

        $user       = $this->users->where("id",$uid)->first();

        if(!$user)
            return response()->setJSON([
                "code"          => 400,
            ]);

        $response = [
            "code"              => 200,
                "html"          => view('Modal/Admin/DeleteUserRequest',[
                    "user"      => $user,
                ]),
        ];

        return response()->setJSON($response);
    }


}
