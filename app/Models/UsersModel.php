<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Validation\ValidationInterface;

class UsersModel extends GeneralModel{
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    public function checkAuth($type= null):bool
    {
        $this->saveCurrentPage();

        dd($this->session->get('lastPage'));
        if(!$this->session->has('auth')) return false;

        return false;
    }

    public function saveCurrentPage():bool
    {
        $router         = service('router');
        $controller     = $router->controllerName();
        $method         = $router->methodName();

        $url            = route_to("$controller::$method",implode("/",$router->params()));

        $this->session->set("lastPage",$url);
        return true;
    }

    public function checkUser($filed,$value,$return= false):bool|object
    {
        $q              = $this->db
                              ->table("users")
                              ->where($filed,$value)
                              ->get();

        if(!$return)
            return (bool)$q->getNumRows();

        return $q->getFirstRow();
    }

    public function verificationAdd($code,$op,$value= null,$clear= false):string
    {
        if($clear)
            self::verificationClear($code,$op);

        if(is_null($value))
            $value= hash("sha256",$op.time());

        $this->db
            ->table("actions")
            ->insert(
                [
                    "code"              => $code,
                    "op"                => $op,
                    "value"             => $value
                ]
            );
        return $value;
    }
    public function verificationClear($code,$op):bool
    {
        $this->db
            ->table("actions")
            ->delete(
                [
                    "code"              => $code,
                    "op"                => $op
                ]
            );

        return true;
    }

}
