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

    public function sdoCreateEmailCURL($user):bool
    {
        $isp                    = "https://31.129.110.26:1500";
        $user                   = "root";
        $pass                   = "spmU&wR@9C7X";

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $params['func']             = 'email.edit';
        $params['sok']              = 'ok';
        $params['name']             = 'sultansv';
        $params['domainname']       = 'stud.mgu-mlt.ru';
        $params['passwd']           = 'MelSU2024';
        $params['owned']            = 'sultansv@std.work-mgu.ru';
        $params['forward']          = 'languder1985@ya.ru';
        $params['out']              = 'xml';

        $url = $isp.'?authinfo='. urlencode($user).':'.urlencode($pass).'&'.http_build_query($params);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result                     = curl_exec($ch);
        $result                     = simplexml_load_string($result,"SimpleXMLElement",LIBXML_NOCDATA);
        if($result->error)
            dd("error");
        else
            dd("success");

        curl_close($ch);

        return true;
    }

    public function verifiedGenerate($user,$withCode = true):bool
    {
        /* generate verified */
        $hash       = self::verificationAdd("verificationByLink",$user->email,null,true);

        if($withCode){
            $code = rand(100000, 999999);

            self::verificationAdd("verificationByCode",$user->email,$code,true);
        }

        /* mail */
        $email          = service('email');

        $body           = view(
            $withCode?"Public/Emails/EmailVerification":"Public/Emails/EmailVerificationByLink",
            [
            "name"                          => $user->name,
            "patronymic"                    => $user->patronymic,
            "email"                         => $user->email,
            "code"                          => &$code,
            "link"                          => base_url("students/email_confirm/$hash"),
        ]);

        $email->setFrom("no-reply@mgu-mlt.ru","No Reply MelSU");
        $email->setTo($user->email);
        $email->setSubject('Подтверждение E-mail');
        $email->setMessage($body);
        $email->send();

        $this->session->set("ssi-email-confirm",$code);

        /**/
        return true;
    }

}
