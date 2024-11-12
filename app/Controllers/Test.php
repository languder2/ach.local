<?php

namespace App\Controllers;

use App\Models\ActionModel;
use App\Models\EmailModel;
use App\Models\LogModule;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use http\Message;
use MoodleRest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        $users = $this->db
            ->table('users')
            ->where("role","teacher")
            ->get()
            ->getResult();


        dd($users);

        echo "<pre>";
        foreach ($users as $user) {


            $c              = $this->db
                                ->table('moodle')
                                ->where("email",$user->email)
                                ->orWhere("login",$user->login)
                                ->countAllResults();


            if($c)
                continue;

            $user->login    = trim(strtolower($user->login));
            $user->email    = trim(strtolower($user->email));

            $pass= $this->users->generateSecurePassword();

            /**/
            $func           = "core_user_create_users";

            $params         = [
                "users"     => [
                    [
                        "username"          => $user->login,
                        "firstname"         => $user->name,
                        "lastname"          => $user->surname,
                        "password"          => $pass,
                        "email"             => trim($user->email),
                    ],
                ]
            ];

            /**/
            $response       = $MoodleRest->request($func, $params);
            if(!isset($response['errorcode'])){
                foreach ($response as $arr) {
                    $assignments        = [
                        "assignments" => [
                            [
                                "roleid"        => 2,
                                "userid"        => $arr['id'],
                                "contextid"     => 1,
                            ],
                        ],
                    ];

                    $MoodleRest->request("core_role_assign_roles", $assignments);

                    $this->db
                        ->table('moodle')
                        ->insert([
                            "email"             => $user->email,
                            "login"             => $user->login,
                            "role"              => "teacher",
                            "muid"              => $arr['id'],
                            "pass"              => $pass,
                        ]);

                    $sql = [
                        "emailTo"               => $user->email,
                        "theme"                 => "Регистрация в системе дистанционного обучения",
                        "message"               => view("Emails/MoodleSignIn",[
                            "name"              => "$user->name $user->patronymic",
                            "login"             => $user->login,
                            "pass"              => $pass,
                        ]),
                    ];

                    $this->db
                        ->table('emails')
                        ->insert($sql);

                }
            }
            else{
                print_r($response['debuginfo']);
                echo "<br>";
            }

        }

    }
    public function moodle2(): void
    {
        $MoodleRest = new MoodleRest(
            'https://do.mgu-mlt.ru/webservice/rest/server.php',
            '680c53cb221f50a12c4da7af6128af15'
        );

        $users = $this->db
            ->table('users')
            ->join("moodle", "moodle.email = users.email", "left")
            ->select("users.tmp,moodle.muid,users.*")
            ->get()
            ->getResult();



        foreach ($users as $user) {
            if(is_null($user->muid)) continue;

            /**
            $pass= $this->users->generateSecurePassword();

            dd($pass);

            $func           = "core_user_update_users";

            $params         = [
                "users"     => [
                    [
                        "id"                => $user->muid,
                        "password"          => $user->tmp,
                    ],
                ]
            ];

            /**
            $response       = $MoodleRest->request($func, $params);

            dd($response);
            /**/

            $sql = [
                "emailTo"               => $user->email,
                "theme"                 => "Регистрация в системе дистанционного обучения",
                "message"               => view("Emails/MoodleSignIn",[
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $user->login,
                    "pass"              => $user->tmp,
                ]),
            ];

            $this->db
                ->table('emails')
                ->insert($sql);

        }

    }


    public function SITeachers()
    {
        $spreadsheet        = IOFactory::load(WRITEPATH."uploads/ed.xlsx");
        $sheet              = $spreadsheet->getSheet(0); // Получение первого листа
        $dataSheet          = $sheet->toArray(null, true, true, true);

        foreach ($dataSheet as $row){
            $email          = strtolower(trim($row['B']));

            if(empty($email)) continue;

            $login          = substr($email, 0, strpos($email, "@"));

            $row['A']       = trim($row['A']);
            $fio            = explode(" ", $row['A']);

            $q= $this->db
                ->table('users')
                ->where('email', $email)
                ->orWhere('login', $login)
                ->countAllResults();

            $pass= $this->users->generateSecurePassword();

            $sql = [
                "role"          => "teacher",
                "login"         => $login,
                "email"         => $email,
                "surname"       => $fio[0]??null,
                "name"          => $fio[1]??null,
                "patronymic"    => $fio[2]??null,
                "tmp"           => $pass
            ];


            if($q){
                $this->db
                    ->table('users')
                    ->update(
                        $sql,
                        [
                            "email"         => $email
                        ]);

                $this->db
                    ->table('users')
                    ->update(
                        $sql,
                        [
                            "login"         => $login
                        ]);
            }
            else {
                $sql['password']    = password_hash($pass, PASSWORD_DEFAULT);

                $this->db
                    ->table('users')
                    ->insert($sql);
            }
        }


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

    public function json()
    {
        $file= WRITEPATH.'uploads/1.json';

        $content = file_get_contents($file);

        $content = mb_convert_encoding($content, 'UTF-8', "windows-1251");

        $content = str_replace("\\","/",$content);

        $content = json_decode($content,true);

        dd($content);
    }

    public function mailing()
    {
        $email          = service('email');

        $emails= $this->db
            ->table('emails')
            ->get()
            ->getResult();

        $c = 0;

        foreach ($emails as $mail){
            if(!empty($mail->emailFrom) && !empty($mail->name))
                $email->setFrom     ($mail->emailFrom,$mail->name);
            else
                $email->setFrom     ("no-reply@mgu-mlt.ru","No Reply MelSU");

            if(!empty($mail->replyTo))
                $email->setReplyTo  ($mail->replyTo);

            if(!empty($mail->protocol))
                $email->setProtocol($mail->protocol);


            $email->setTo           ($mail->emailTo);
            $email->setSubject      ($mail->theme);
            $email->setMessage      ($mail->message);
            $email->send();

            $this->db
                ->table('emails')
                ->delete([
                    "id"            => $mail->id
                ]);

            $c++;
            echo "To $mail->emailTo send<br>";
        }
        return "success: $c send";
    }

    public function generateEmails()
    {
        $users = $this->db
            ->table('moodle')
            ->join('users',"moodle.email = users.email","left")
            ->select('moodle.email as mailTo, users.*')
            ->get()
            ->getResult();

        foreach ($users as $user){
            if(is_null($user->email))
                dd($user);

            $sql = [
                "emailTo"               => $user->email,
                "theme"                 => "Регистрация в системе дистанционного обучения",
                "message"               => view("Emails/MoodleSignIn",[
                    "name"              => "$user->name $user->patronymic",
                    "login"             => $user->login,
                    "pass"              => $user->tmp,
                ]),
            ];

            $this->db
                ->table('emails')
                ->insert($sql);

        }
        return "success";
    }

    public function saveXLS()
    {
        /**/
        $result         = $this->db
            ->table("faculties")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        $faculties = [];

        foreach ($result as $item)
            $faculties[$item->id] = $item->name;

        /**/
        $result         = $this->db
            ->table("departments")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        $departments = [];

        foreach ($result as $item)
            $departments[$item->id] = $item->name;

        /**/
        $result         = $this->db
            ->table("levels")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        $levels = [];

        foreach ($result as $item)
            $levels[$item->id] = $item->name;

        /**/
        $result         = $this->db
            ->table("specialities")
            ->orderBy("code")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        $specialities = [];

        foreach ($result as $item){
            $specialities[$item->id]    = $item->name;
            $codes[$item->id]           = $item->code;
        }

        /**/
        $students= $this->db
            ->table("students")
            ->join("users","students.uid = users.id","left")
            ->select("
                students.*, users.surname, users.name, users.patronymic, users.email 
            ")
            ->orderBy("students.faculty")
            ->orderBy("students.level")
            ->orderBy("students.speciality")
            ->get()
            ->getResult();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $n=2;
        $sheet->setAutoFilter("A2:K2");


        $sheet->setCellValue("A1", "Факультет");
        $sheet->setCellValue("B1", "Кафедра");
        $sheet->setCellValue("C1", "Код спец.");
        $sheet->setCellValue("D1", "Специальность");
        $sheet->setCellValue("E1", "Уровень");
        $sheet->setCellValue("F1", "Курс");
        $sheet->setCellValue("G1", "Группа");
        $sheet->setCellValue("H1", "Фамилия");
        $sheet->setCellValue("I1", "Имя");
        $sheet->setCellValue("J1", "Отчество");
        $sheet->setCellValue("K1", "Email");

        foreach ($students as $key=>$value){
            $n++;
            $sheet->setCellValue("A$n", $faculties[$value->faculty]);
            $sheet->setCellValue("B$n", $departments[$value->department]);
            $sheet->setCellValue("C$n", $codes[$value->speciality]);
            $sheet->setCellValue("D$n", $specialities[$value->speciality]);
            $sheet->setCellValue("E$n", $levels[$value->level]);
            $sheet->setCellValue("F$n", $value->course);
            $sheet->setCellValue("G$n", $value->grp);
            $sheet->setCellValue("H$n", $value->surname);
            $sheet->setCellValue("I$n", $value->name);
            $sheet->setCellValue("J$n", $value->patronymic);
            $sheet->setCellValue("K$n", $value->email);
        }
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);
        $writer = new Xlsx($spreadsheet);
        $fileName= WRITEPATH . "/report.xlsx";
        $fileName= str_replace("//","/",$fileName);
        $writer->save($fileName);

    }

    public function test()
    {
        $action = model(ActionModel::class);

        $action
            ->where("time<","2024-11-06")
            ->delete();
            /**

        [
            "emailTo"       => "test@ya.ru"
        ]);
            /**/

    }

    public function logTest()
    {
        model(LogModule::class)->insert(
            [
                "subject"       => 6,
                "object"        => 6,
                "action"        => "send email",
                "type"          => "test",
            ]
        );
    }

    
}



