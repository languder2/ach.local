<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
class Event extends BaseController
{
    public function eventSignupForm():string
    {

        $faculties      = $this->db
            ->table("faculties")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        /**/
        $specialities   = $this->db
            ->table("specialities")
            ->orderBy("code")
            ->orderBy("name")
            ->get()
            ->getResult()
        ;

        $content   = view('Events/Public/Form',[
            "form"          => &$form,
            "faculties"     => $faculties,
            "specialities"  => $specialities,

        ]);

        $bgImage    = "img/bgs/21.11.24.jpg";

        return view('Events/Public/Template',[
            "content"       => &$content,
            "bgImage"       => &$bgImage,
        ]);
    }

    public function eventSignupSave():RedirectResponse
    {

        $form       = (object)$this->request->getPost('form');

        /**
        $user       = model("UsersModel")->where("email", $form->email)->first();

        if($user !== null)
        $form->uid  = $user->id;

        /**/
        model("EventModel")->where("phone",$form->phone)->delete();
        $iID = model("EventModel")->insert($form);

        return redirect()->to("event/signup/success");
    }

    public function eventSignupSuccess():string
    {
        $bgImage    = "img/bgs/21.11.24.jpg";

        $content   = view('Events/Public/MessageSuccess',[

        ]);

        return view('Events/Public/Template',[
            "content"       => &$content,
            "bgImage"       => &$bgImage,
        ]);
    }

    public function showResults()
    {

        $page= $this->request->getGet("page_app")??1;

        $users= $this->users
            ->join("e","users.id=moodle.uid","left")
            ->join("students", "students.uid = users.id","left")
            ->select("
                users.*,
                moodle.muid,
                COUNT(students.id) as students
            ")
            ->groupBy("users.id")
        ;
        $list       = $users->paginate($this->perPage, "users", $page);

        $pageContent= view(
            "Admin/Users/List",
            [
                "list"          => $list,
                "pager"         => $users->pager->links("users","admin"),
                "total"         => $users->pager->getTotal("users"),
                "filter"        => &$filter,
                "message"       => &$message,
            ]
        );

        return view('Public/Page',[
            "pageContent" => &$pageContent,
        ]);
    }

}
