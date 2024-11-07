<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\UsersModel;

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

        $page= $this->request->getGet("page_teachers")??1;

        $users= $this->users
            ->where("JSON_CONTAINS(users.roles, '\"teacher\"', '$')")
            ->orderBy("users.id")
        ;


        if(session()->has("AdminTeacherSearch")){
            $search             = session()->get("AdminTeacherSearch");

            $str                = str_replace(" ","%",$search);
            $searchPhone        = str_replace([" ","(",")","-","_","+"],"",$search);

            $users->groupStart()
                    ->like("users.email", $str)
                    ->orLike("CONCAT(users.surname, ' ', users.name, ' ', users.patronymic)",$str)
                    ->orLike("CONCAT(users.name, ' ', users.patronymic, ' ', users.surname)",$str)
                    ->orlike("users.phone",$searchPhone)
                ->groupEnd()
            ;
        }

        $list = $users->paginate($this->perPage, "teachers", $page);


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

    public function correct():void
    {
        $users= $this->users
            ->join("moodle","moodle.email=users.email","right")
            ->where("JSON_CONTAINS(users.roles, '\"teacher\"', '$')")
            ->select("users.*")
            ->findAll();
    }

}
