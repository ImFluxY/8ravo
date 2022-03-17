<?php
require_once('common.php');
require_once('./templates/begin.php');
?>

<title>Module - 8ravo</title>
<link rel="stylesheet" href="./css/home.css">
<link rel="stylesheet" href="./css/texte.css">
<link rel="stylesheet" href="./css/video.css">
<link rel="stylesheet" href="./css/quiz.css">
<link rel="stylesheet" href="./css/module-end.css">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main class="main">
        <?php require_once('./templates/module_step.php'); ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="./js/module.js"></script>
    <?php
    require_once('./templates/end.php');
    ?>