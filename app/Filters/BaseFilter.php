<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BaseFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->has('isLoggedIn')) {

            define("HAS_LOGGED",true);

            $db= \Config\Database::connect();

            $user= $db->table("users")
                ->where("id",session()->get("isLoggedIn")->id)
                ->get()
                ->getFirstRow();

            $user->roles = json_decode($user->roles);

            if(is_null($user->roles))
                $user->roles= [];

            define("HAS_ROLES",$user->roles);
        }

        $uri = $request->getUri();        // Получаем сегменты URL
        $segments = $uri->getSegments();        // Проверяем, есть ли сегмент 'account'

        if (in_array('account', $segments))
            if(!session()->has('isLoggedIn'))
                return redirect()->to('/');

        if (in_array('admin', $segments))
            if(!isset($user) or !in_array("admin", $user->roles))
                return redirect()->to('/');

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
