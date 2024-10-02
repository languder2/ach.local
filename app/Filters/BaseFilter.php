<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BaseFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null):bool|RedirectResponse
    {
        if (session()->has('isLoggedIn')) {

            define("HAS_LOGGED",true);

            $user= session()->get('isLoggedIn');

            if($user->role === "admin")
                define("HAS_LOGGED_ADMIN",true);
        }

        /**
        $uri = $request->getUri();        // Получаем сегменты URL
        $segments = $uri->getSegments();        // Проверяем, есть ли сегмент 'account'

        if (in_array('account', $segments))
            define("HAS_ACCOUNT",true);
        /**/

        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
