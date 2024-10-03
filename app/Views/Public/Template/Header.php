<header>
    <div class="container-lg">
        <nav class="text-white">
            <div class="d-flex">
                <div>
                    <?= view("Public/Template/Logo")?>
                </div>

                <div class="ms-auto"></div>

                <div class="ms-2">
                    <a href="#" class="btn-account show-modal" data-action="#askQuestion">
                        <span class="d-none d-sm-block">
                            Поддержка
                        </span>
                        <i class="bi bi-chat-left d-sm-none"></i>
                    </a>
                </div>

                <?php if(defined("HAS_LOGGED")):?>
                    <?php if(!defined("HAS_ACCOUNT")):?>
                        <div class="ms-2">
                            <a
                                    href            ="<?=base_url(route_to("Pages::account"))?>"
                                    class           ="btn-account"
                            >
                                <span class="d-none d-sm-block">
                                    личный кабинет
                                </span>
                                <i class="bi bi-person d-sm-none"></i>
                            </a>
                        </div>
                    <?php endif;?>

                    <?php if(defined("HAS_LOGGED_ADMIN")):?>
                        <div class="ms-2 d-none d-md-block">
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
                            <span class="d-none d-sm-block">
                                выход
                            </span>
                            <i class="bi bi-box-arrow-right d-sm-none"></i>
                        </a>
                    </div>
                <!--
                    <div class="ms-auto ms-2 d-md-none">
                        <div id="show-menu" class="show-menu btn-account">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    -->
                <?php else:?>
                    <div class="ms-2">
                        <a href="#" class="btn-account show-modal" data-action="#signIn">
                            <span class="d-none d-sm-block">
                                войти
                            </span>
                            <i class="bi bi-person d-sm-none"></i>
                        </a>
                    </div>
                <?php endif;?>
            </div>
        </nav>

        <!--
        <ul id="menu" class="text-end my-0">
            <li>
                <a href="#" class="link text-white">
                    123
                </a>
            </li>
            <li>Сменить пароль</li>
            <li>Пройти верификацию</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
            <li>1</li>
        </ul>
        -->
    </div>
</header>
