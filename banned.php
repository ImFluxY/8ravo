<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
    <title>Compte suspendu - 8ravo</title>
</head>

<body>
<?php require_once('./templates/menu.php'); ?>
    <main>
        <section id="banned" class="sectionBanned">
            <img src="./img/banned.svg" alt="sens interdit" class="img-banned">
            <h1>Oups ! Il semblerait que votre compte est été suspendu !</h1>
            <div class="block-btn-banned">
                <a href="./index.php" class="btn-back-home">Accueil</a>
                <a href="./contact.php" class="btn-contact">Nous contacter</a>
            </div>      
        </section>
    </main>
    <?php
    require_once('./templates/end.php');
    ?>