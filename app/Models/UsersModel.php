<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class UsersModel extends GeneralModel{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id',
        'login',
        'email',
        "roles",
        "surname",
        "name",
        "patronymic",
        "messenger",
        "phone",
        "verified"
    ];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
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

        curl_close($ch);

        if($result->error)
            return false;
        else
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
    public function verifiedGenerateCron($user):object
    {
        /* generate verified */
        $hash       = self::verificationAdd("verificationByLink",$user->email,null,true);

        $code = rand(100000, 999999);
        self::verificationAdd("verificationByCode",$user->email,$code,true);

        /**/
        return (object)[
            "code"              => $code,
            "hash"              => $hash,
        ];
    }

    public function setAction($code,$op,$value):int
    {
        $this->db
            ->table("actions")
            ->insert([
                "code"      => $code,
                "op"        => $op,
                "value"     => $value,
            ]);

        return $this->db->insertID();
    }
    public function deleteAction()
    {

    }

    public function getAction($code,$op = null,$value= null)
    {
        $where= [
            "code"          => $code
        ];

        if($op)
            $where["op"] = $op;

        if($value)
            $where["value"] = $value;

        $q= $this->db
            ->table("actions")
            ->where($where)
        ->get()
        ->getFirstRow()
        ;

        return $q;
    }

    public function updateLogged():object|null
    {
        if(!$this->session->has("isLoggedIn"))
            return null;

        $user           = $this->session->get("isLoggedIn");

        $user = $this->db
            ->table("users")
            ->where("id",$user->id)
            ->get()
            ->getFirstRow();

        $this->session->set("isLoggedIn",$user);

        return $user;
    }

    public function generateSecurePassword($length = 12):string
    {
        if ($length < 8)
            $length         = 8;

        $lowercase          = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase          = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers            = '0123456789';
        $specialChars       = '!@#$%^&*';

        $allChars           = $lowercase . $uppercase . $numbers . $specialChars;

        $password           = $lowercase[rand(0, strlen($lowercase) - 1)]
                            . $uppercase[rand(0, strlen($uppercase) - 1)];

        for ($i = 4; $i < $length; $i++)
            $password .= $allChars[rand(0, strlen($allChars) - 1)];

        $password           .= $numbers[rand(0, strlen($numbers) - 1)]
                            . $specialChars[rand(0, strlen($specialChars) - 1)];

        return str_shuffle($password);
    }// Пример использования


    public function updateRoles($uid,$role):bool
    {
        $roles = $this->db
            ->table("users")
            ->where("id",$uid)
            ->get()
            ->getFirstRow()
            ->roles
        ;

        $roles= json_decode($roles);

        if(is_null($roles))
            $roles      = [];

        if(in_array($role,$roles))
            return false;

        $roles[]        = $role;

        $roles= json_encode(
            $roles,
            JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT
        );

        $this->db
            ->table("users")
            ->update(
                [
                    "roles"         => $roles
                ],
                [
                    "id"            =>$uid
                ]
            );

        return true;
    }

    public static function listPreparing($list):array
    {
        return array_map(function($item) {
            $item->roles = json_decode($item->roles);
            return $item;
        }, $list);
    }

    public static function prepareLoginFromEmail($email):string
    {
        return substr($email,0,strpos($email,"@"));
    }

}
