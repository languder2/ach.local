<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Личный кабинет</title>

    <link href="<?=base_url("node_modules/bootstrap/dist/css/bootstrap.min.css")?>" rel="stylesheet">
    <link href="<?=base_url("node_modules/bootstrap-icons/font/bootstrap-icons.min.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("css/style.css")?>?<?=microtime(true)?>">
    <link rel="stylesheet" href="<?=base_url("css/forms.css")?>?<?=microtime(true)?>">
    <link rel="stylesheet" href="<?=base_url("css/modal.css")?>?<?=microtime(true)?>">
    <link rel="stylesheet" href="<?=base_url("css/bs-addon.css")?>?<?=microtime(true)?>">

    <script defer src="<?=base_url("node_modules/bootstrap/dist/js/bootstrap.bundle.min.js")?>"></script>
    <!--
    <script defer src="node_modules/@popperjs/core/dist/esm/popper.js"></script>
    -->
    <script defer src="<?=base_url("js/script.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/modal.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/user.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/dependent-selects.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/ssi-timer.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/number-code.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/menu.js")?>?<?=microtime(true)?>"></script>
    <script defer src="<?=base_url("js/question.js")?>?<?=microtime(true)?>"></script>
    <script defer src="//code.jivo.ru/widget/TLPC8alVpo" async></script>
</head>
<body>
<?php
    echo view("Public/Template/Header");
?>
<section class="page-content py-4">
    <div class="container-xxl">
        <?=$pageContent??view("welcome_message")?>
    </div>
</section>
    <?php
        echo view("Public/Template/Footer");
    ?>
</body>
</html>