<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!defined("HAS_LOGGED")) {
            return redirect()->to('/');
        }


        $uri = $request->getUri();        // Получаем сегменты URL
        $segments = $uri->getSegments();        // Проверяем, есть ли сегмент 'account'

        if (in_array('account', $segments))
            define("HAS_ACCOUNT",true);
    }

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
