<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
<title>Devenir créateur - 8ravo</title>
<link rel="stylesheet" href="./css/devenir_createur.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main class="main">
        <section class="devCrea">
            <div class="devCrea-container container">
                <img src="./img/infographie/imageCrea.svg" alt="" class="devCrea-img">
                <div class="devCrea-data">
                    <h1 class="devCrea-title">Devenez Créateur !</h1>
                    <div class="devCrea-texte">
                        <p>
                            Vous avez la fibre créative et vous avez envie de partager vos connaissances ?
                        </p>
                        <p>
                            Alors n’attendez plus, faite votre demande et soyez selectionné pour participer
                            au développement de <strong>8ravo</strong> en devenant créateur. Avec notre soutien, vous pourrez
                            alors créer et publier vos propres modules d’apprentissage en 8 étapes approuvé
                            et reconnu par notre plateforme.
                        </p>
                        <p>
                            De l’histoire à la science en passant par l’art et les mathématiques, nous
                            n’attendons que vous pour enrichir le contenu des autres utilisateurs avec
                            de la culture formulée avec vos mots.
                        </p>
                    </div>

                    <a id="button" href="./formulaire_createur.php" class="button-devCrea">Faire la demande</a>
                </div>
            </div>
        </section>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <?php
    require_once('./templates/end.php');
    ?>