<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
    <link rel="stylesheet" href="./css/contact.css" type="text/css" />
    <title> "Contact Bravo"</title>
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main>
        <?php
        if (!isset($_POST['valider'])) { ?>
            <section id="contact" class="sectionContact">
                <div class="divForm">
                    <h2 class="title">Nous contacter</h2>
                    <form action="" id="formulaire" class="contactForm" method="post">
                        <div class="row firstRow">
                            <div class="col">
                                <label for="nom">Nom</label>
                                <input class="inputContact" name="nom" id="nom" required type="text">
                            </div>

                            <div class="col">
                                <label for="prenom">Prénom</label>
                                <input class="inputContact" name="prenom" id="prenom" required type="text">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="email">E-mail</label>
                                <input class="inputContact" name="email" id="email" required type="email">
                            </div>

                            <div class="col">
                                <label for="objet">Objet</label>
                                <input class="inputContact" name="objet" id="objet" required type="text">
                            </div>
                        </div>

                        <div class="divMessage">
                            <label for="message">Message</label>
                            <textarea class="textMessage inputContact" name="message" id="message" required type="text"></textarea>
                        </div>

                        <input class="btnForm" type="submit" id="valider" name="valider" value="→ Envoyer le formulaire" />

                        <?php
                        require_once('./php/divErreur.php');
                        ?>

                        <div class="reseaux">
                            <a class="itemReseau" target="_blank" href="https://www.instagram.com/8ravo_education/?hl=fr"><img src="./img/logo_instagram.png" alt="Logo Instagram"></a>
                            <a class="itemReseau" target="_blank" href="https://twitter.com/8ravo_education"><img src="./img/logo_twitter.png" alt="Logo Twitter"></a>
                            <a class="itemReseau" target="_blank" href="https://www.linkedin.com/company/8ravo/"><img src="./img/logo_linkedin.png" alt="Logo Linkedin"></a>
                            <a class="itemReseau" target="_blank" href="https://www.facebook.com/8ravoeducation/?__xts__[0]=68.ARBTUt2f0l9i750EYozJSiexCWf-55bauhF6aG2O9O6hpwdsJD8GRlatMyZKrB--bRMgF9eXNabw4L3IiqDkiKDhI22GDlACbNYDJtEpkAoBZVZhbTgppVPWc7ExoGJnjW5yPTMZ3VA1VY4anmH-7ZF0ye9QIIjSiz0R4ucc73LAbdTs4E1Yt-qxrvA8JxcmDcYn4j8vWaY3_-cdoMqHtljKzjOm0SwOlY5fl1BKZ2uQvD7sWjl_1UPV9IVsSUbugej0uG3_lFzKn06gdoAU7zmdHTf0nWyRV1FuE4cPu9ER9jj93duC2yaSLjes8g&__xts__[1]=68.ARCz1bjcBh1j_x0TQgM3zArbr1OIHZNcPfxaFfG7ekJGLcu3DbQVYAObX4AjMcPswWr2x4biSenZ1U8tDOn4Hy6z0YhQNxrMkrH32a2Yles97nW_tStPjwTwda0Ce8v1g3o0y_7fLVgdgeksWGUe5tZS4PhGztyo1e3qXk_O0T2_MpPegMA9YV6H6kN8vyei43oqI2Y_XboB6v0M_IvZz9D6a2mwtddm5iTl1zVfqI10io2CZCzpc4fS_Z-5PkxD3WM9xlGftjolYTHdgstbu5o70yvfihOVOvHShBoY9MdKzDsy8P-ZOcY6q97yjQ"><img src="./img/logo_facebook.svg" alt="Logo Facebook"></a>
                        </div>
                    </form>
                </div>

            </section>
            <?php
        }
        if (isset($_POST['valider'])) {

            $allParamsPresent = isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['objet']) && isset($_POST['message']);
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $objet = $_POST['objet'];
            $message = $_POST['message'];

            if ($prenom === "" || $nom === "" || $email === "" || $objet === "" || $message === "") {
                error("Tous les champs doivent être remplis.", "contact.php");
            }

            try {
                $cnx = new Base(BASE, USERNAME, PASSWORD);

                $cnx->insert(
                    "insert into contact values (?,?,?,?,?,?)",
                    array(null, $prenom, $nom, $email, $objet, $message)
                );
            ?>
                <section id="contactValide" class="sectionContact">
                    <div class="divForm">
                        <img src="./img/message_envoye.svg" class="imgEnvoyee" alt="message envoyée">
                        <h2 class="title">Message bien envoyé</h2>
                        <a class="btnRetour" href="index.php">Retourner à l'accueil</a>
                    </div>
                </section>
        <?php
            } catch (PDOException $e) {
                error("Un problème est survenu lors de votre prise de contact : " . $e->getMessage() . " " . $e->getTraceAsString(), 'contact.php');
            }

            $db = null;
        } else {
        }
        ?>
    </main>
    <?php require_once('./templates/end.php'); ?>