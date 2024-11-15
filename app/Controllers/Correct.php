<?php

namespace App\Controllers;

use App\Models\MoodleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Correct extends BaseController
{
    public function moodleRoles():ResponseInterface
    {
        $users = model(MoodleModel::class)
            ->join("users", "users.id = moodle.uid")
            ->where("JSON_CONTAINS(users.roles, '\"teacher\"', '$')")
            ->findAll()
        ;

        foreach ($users as $user)
            model(MoodleModel::class)->AssigningRole($user->muid);


        return response()->setJSON([
            "code"      => 200
        ]);
    }
}
