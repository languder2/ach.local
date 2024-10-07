<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('isLoggedIn'))
            return redirect()->to('/');

        $user= session()->get('isLoggedIn');

        if(!in_array($user->roles,["admin","manager"]))
            return redirect()->to('/');

        return false;
    }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
