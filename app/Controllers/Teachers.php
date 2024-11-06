<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\StudentModel;

class Teachers extends BaseController
{
    protected int $perPage = 30;
    protected UsersModel $users;

    public function __construct()
    {
        $this->users        = model(UsersModel::class);
    }

    public function adminTeachers(): string
    {

        $page= $this->request->getGet("page_students")??1;

        $users= $this->users
            ->where("JSON_CONTAINS(users.roles, '\"teacher\"', '$')")
            ->orderBy("users.id")
        ;


        if(session()->has("AdminTeacherSearch")){
            $search = session()->get("AdminTeacherSearch");

            $str    = str_replace(" ","%",$search);

            $users->like("surname", $str)
                    ->orLike("name", $str)
                    ->orLike("patronymic", $str)
                    ->orLike("email", $str)
                    ->orLike("CONCAT(surname, ' ', name, ' ', patronymic)",$str)
                    ->orLike("CONCAT(name, ' ', patronymic, ' ', surname)",$str)
            ;
        }

        $list = $users->paginate($this->perPage, "students", $page);


        $pageContent= view(
            "Admin/Teachers/List",
            [
                "list"          => $list,
                "pager"         => $users->pager->links("teachers","admin"),
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
            session()->remove("AdminTeacherSearch");

        else
            session()->set("AdminTeacherSearch",$search);

        return redirect()->to("admin/teachers");
    }
}
