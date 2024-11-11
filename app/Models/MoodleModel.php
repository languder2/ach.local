<?php

namespace App\Models;

use CodeIgniter\Model;
use MoodleRest;

class MoodleModel extends Model
{
    protected $table            = 'moodle';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "muid",
        "uid",
        "email",
        "login",
        "role",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected string $token     = 'b6ec48e0a26f33c7dce5418139990d51';
    protected string $apiLink   = 'https://do.mgu-mlt.ru/webservice/rest/server.php';


    public function CreateUser(object $user)
    {
        $MoodleRest     = new MoodleRest(
            $this->apiLink,
            $this->token
        );

        $func           = "core_user_create_users";

        $params         = [
            "users"     => [
                [
                    "username"          => $user->login,
                    "firstname"         => $user->name,
                    "lastname"          => $user->surname,
                    "password"          => $user->pass,
                    "email"             => $user->email,
                ],
            ]
        ];

        return $MoodleRest->request($func, $params);
    }

    public function getUser(int $id):array
    {
        $MoodleRest     = new MoodleRest(
            $this->apiLink,
            $this->token
        );

        $func           = "core_user_get_users";

        $params         = [
            "criteria"     => [
                [
                    "key"               => "id",
                    "value"             => $id,
                ],
            ]
        ];

        return $MoodleRest->request($func, $params);
    }

    public function changePass(int $id, string $pass):array
    {
        $MoodleRest     = new MoodleRest(
            $this->apiLink,
            $this->token
        );

        $func           = "core_user_update_users";

        $params         = [
            "users"     => [
                [
                    "id"                => $id,
                    "password"          => $pass,
                ],
            ]
        ];

        return $MoodleRest->request($func, $params);

    }


}
