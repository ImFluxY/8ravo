<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
    <title>Erreur d'accès - 8ravo</title>
</head>

<body>
<?php require_once('./templates/menu.php'); ?>
    <main>
        <section id="access" class="sectionAccess">
            <img src="./img/prohibited.svg" alt="sens interdit" class="img-access">
            <h1>Oups ! Il semblerait que vos droits n’autorisent pas l’accès à cette page !</h1>
            <div class="block-btn-access">
                <a href="./index.php" class="btn-back-home">Accueil</a>
                <a href="./contact.php" class="btn-contact">Nous contacter</a>
            </div>      
        </section>
    </main>
    <?php
    require_once('./templates/end.php');
    ?>