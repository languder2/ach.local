<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use http\Message;
use MoodleRest;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Test extends BaseController
{
    protected object $users;
    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function moodle(): void
    {
        $MoodleRest = new MoodleRest(
            'https://do.mgu-mlt.ru/webservice/rest/server.php',
            '680c53cb221f50a12c4da7af6128af15'
        );

/**
        $assignments        = [
            "assignments" => [
                [
                    "roleid"        => 3,
                    "userid"        => 61,
                    "contextid"     => 1794,
                ],
                [
                    "roleid"        => 2,
                    "userid"        => 61,
                    "contextid"     => 1,
                ],
            ],
        ];
        $response       = $MoodleRest->request("core_role_assign_roles", $assignments);

        dd($response);

/**/
        $func           = "core_user_create_users";

        $params         = [
            "users"     => [
                [
                    "username"          => "devtest3",
                    "firstname"         => "firstname",
                    "lastname"          => "lastname",
                    "password"          => "WorkMGU2024!",
                    "email"             => "languder3@gmail.com",
                ],
                [
                    "username"          => "devtest4",
                    "firstname"         => "firstname",
                    "lastname"          => "lastname",
                    "password"          => "WorkMGU2024!",
                    "email"             => "languder4@gmail.com",
                ],
                [
                    "username"          => "devtest5",
                    "firstname"         => "firstname",
                    "lastname"          => "lastname",
                    "password"          => "WorkMGU2024!",
                    "email"             => "languder5@gmail.com",
                ],
            ]
        ];
/**/
        $response       = $MoodleRest->request($func, $params);

        dd($response);
    }


    public function SITeachers()
    {
        $spreadsheet = IOFactory::load(WRITEPATH."uploads/ed.xlsx");
        $sheet = $spreadsheet->getSheet(0); // Получение первого листа
        $dataSheet = $sheet->toArray(null, true, true, true);
        dd($dataSheet);
        foreach ($dataSheet as $key=>$row){}


        $dataSheet = $sheet->toArray(null, true, true, true);

    }
    public function students()
    {
        $users = $this->db
            ->table('users')
            ->where('faculty is not null')
            ->get()
            ->getResult();

        foreach ($users as $user){
            $sql= [
                "uid"           => $user->id,
                "faculty"       => $user->faculty,
                "department"    => $user->department,
                "level"         => $user->level,
                "course"        => $user->course,
                "grp"           => $user->grp,
                "speciality"    => $user->speciality,
            ];

            $this->db->table('students')->insert($sql);

        }

    }
}



