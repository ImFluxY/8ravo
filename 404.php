<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
    <title>404 - 8ravo</title>
</head>

<body>
<?php require_once('./templates/menu.php'); ?>
    <main>
        <section id="404" class="section404">
            <div class="wrapper404">
            <img src="./img/404.svg" alt="404" class="img-404">
            <h1>Oups ! Il semble que cette page n'existe pas !</h1>
            <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn-back-home btn404">Retour</a>
            </div>
        </section>
    </main>
    <?php
    require_once('./templates/end.php');
    ?>