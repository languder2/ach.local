<header>
    <nav class="container-lg text-white">
        <div class="d-flex">
            <div>
                <?= view("Public/Template/Logo")?>
            </div>
            <?php if(isset($user)):?>
                <div class="ms-auto">
                    <a
                            href            ="<?=base_url(route_to("Pages::account"))?>"
                            class           ="btn-account"
                    >
                        личный кабинет
                    </a>
                </div>

                <?php if($user->role === "admin"):?>
                    <div class="ms-2">
                        <a
                                href            ="<?=base_url(route_to("Pages::adminIndex"))?>"
                                class           ="btn-account"
                        >
                            админ панель
                        </a>
                    </div>
                <?php endif;?>

                <div class="ms-2">
                    <a
                            href            ="<?=base_url(route_to("Users::exit"))?>"
                            class           ="btn-account"
                    >
                        выход
                    </a>
                </div>
            <?php else:?>
                <div class="ms-auto">
                    <a href="#" class="btn-account show-modal" data-action="#signIn">
                        войти
                    </a>
                </div>
            <?php endif;?>
        </div>
    </nav>
</header>
