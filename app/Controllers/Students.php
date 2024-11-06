<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\StudentModel;

class Students extends BaseController
{
    protected int $perPage = 30;
    protected UsersModel $users;

    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function adminStudents(): string
    {

        $page= $this->request->getGet("page_students")??1;

        $users= $this->users
            ->join("students", "students.uid = users.id","left")
            ->join("faculties", "faculties.id = students.faculty","left")
            ->join("departments", "departments.id = students.department","left")
            ->join("levels", "levels.id = students.level","left")
            ->join("specialities", "specialities.id = students.speciality","left")
            ->join("edForms", "edForms.id = students.form","left")
            ->select("
                users.*,
                IF(uid IS NULL, NULL, 
                    GROUP_CONCAT(
                        JSON_OBJECT(
                            'faculty',      faculties.name,
                            'department',   departments.name,
                            'level',        levels.name,
                            'form',         edForms.name,
                            'code',         specialities.code,
                            'speciality',   specialities.name,
                            'course',       students.course,
                            'group',        students.grp
                            
                        )
                    )
                ) AS list
            ")
//            ->where("JSON_CONTAINS(users.roles, '\"student\"', '$')")
            ->groupBy("users.id")
            ->orderBy("users.id")
        ;

        if(session()->has("AdminStudentsSearch")){
            $search         = session()->get("AdminStudentsSearch");

            $str            = str_replace(" ","%",$search);
            $users->like("users.surname", $str)
                    ->orLike("users.name", $str)
                    ->orLike("users.patronymic", $str)
                    ->orLike("users.email", $str)
                    ->orLike("CONCAT(users.surname, ' ', users.name, ' ', users.patronymic)",$str)
                    ->orLike("CONCAT(users.name, ' ', users.patronymic, ' ', users.surname)",$str)

            ;
        }

        $list = $users->paginate($this->perPage, "students", $page);

        $pageContent= view(
            "Admin/Students/List",
            [
                "list"          => $list,
                "pager"         => $users->pager->links("students","admin"),
                "count"         => $users->countAllResults(),
                "search"        => &$search
            ]
        );

        return view('Admin/Page',[
            "user"              => $this->user??null,
            "pageContent"       => &$pageContent
        ]);
    }

    public function setFilter():RedirectResponse
    {
        $search = $this->request->getPost("search")??null;

        if(empty($search))
            session()->remove("AdminStudentsSearch");

        else
            session()->set("AdminStudentsSearch",$search);

        return redirect()->to("admin/students");
    }
}
