<div id="modal">
    <div id="modalContent">
        <?php
            if(!defined("HAS_LOGGED")){
                echo view("Public/Users/SignIn",[]);
                echo view("Public/Users/SignUp",[]);
                echo view("Public/Users/RecoverPassword",[]);
            }
            else
                $user= session()->get("isLoggedIn");


            echo view("Public/Modals/AskQuestion",[
                "user"          => &$user
            ]);
        ?>
        <div
            id          = "message"
            class       = "panel d-none"
        >
            123
        </div>
    </div>
</div>
