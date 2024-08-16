<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class DisableDebugBar implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {


        // Отключаем DebugBar
//        \Config\Services::toolbar()->disable();
//        service('toolbar')->respond();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Ничего не делаем после запроса
    }
}