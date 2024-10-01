<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use http\Message;

class test extends BaseController
{
    protected object $users;
    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function index(): void
    {

        $uri = $this->request->getUri();        // Получаем сегменты URL
        $segments = $uri->getSegments();        // Проверяем, есть ли сегмент 'account'
        if (in_array('account', $segments))
            dd(1);
    }


}



