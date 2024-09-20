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

    
}



