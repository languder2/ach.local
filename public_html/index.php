<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Личный кабинет</title>

    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css?<?=microtime(true)?>">
    <link rel="stylesheet" href="css/forms.css?<?=microtime(true)?>">

    <script defer src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--
    <script defer src="node_modules/@popperjs/core/dist/esm/popper.js"></script>
    -->
    <script defer src="js/modal.js?<?=microtime(true)?>"></script>
</head>
<body>
<?php include_once("header.php");?>
<section class="page-content py-4">
    <?php include_once("content/MainPage.php")?>
</section>

<?php include_once("footer.php");?>
</body>
</html>