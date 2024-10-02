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

        define("HAS_LOGGED",true);

        $user= session()->get('isLoggedIn');

        if($user->role === "admin")
            define("HAS_LOGGED_ADMIN",true);

        if(!in_array($user->role,["admin","manager"]))
            return redirect()->to('/');

        return false;
    }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
