<div id="modal">
    <div id="modalContent">
        <?php
            echo view("Public/Users/SignIn",[]);
            echo view("Public/Users/SignUp",[]);
            echo view("Public/Users/RecoverPassword",[]);
        ?>
        <div
            id          = "message"
            class       = "panel d-none"
        >
            123
        </div>
    </div>
</div>
