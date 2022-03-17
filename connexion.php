<!DOCTYPE html>
<?php
require_once("common.php");
require_once('./templates/begin.php');
?>
<?php
// script de connexion d'un utilisateur
if (isset($_POST['valider'])) {
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $user = UserModel::auth($email, $pwd);
    $mail_8ravo = "projets-mmi@univ-lemans.fr";

    if ($user == null) {
        error(
            "L'identifiant ou le mot de passe est incorrect",
            "connexion.php"
        );
    } else if ($user->getBanned() == 1) {
        header("Location: ./banned.php");
    } else {
        $_SESSION['user'] = $user;
        header("Location: ./index.php");
    }
} ?>
<link rel="stylesheet" href="./css/contact.css" type="text/css" />
<link rel="stylesheet" href="./css/connexion.css" type="text/css" />
<title> "Connexion Bravo"</title>
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main>
        <section id="connexion" class="sectionConnexion">
            <div class="divForm">
                <h2 class="title">Connexion</h2>
                <form action="" id="formulaire" class="contactForm" method="post">
                    <div class="row firstRow">
                        <div class="col">
                            <label for="email">E-mail</label>
                            <input class="inputContact" name="email" id="email" type="email" required>
                            <label for="mdp">Mot de passe</label>
                            <input class="inputContact" type="password" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="options">
                        <p class="optionLigne">Mot de passe oublié? <a class="boldLink" href="mdp_oublie.php">Cliquez ici</a></p>
                        <p class="optionLigne">Pas encore inscrit? <a class="boldLink" href="inscription.php">S'inscrire</a></p>
                    </div>
                    <div class="connect-button">
                        <input class="btnConnexion" type="submit" id="valider" name="valider" value="→ Se connecter" />
                    </div>
                    <?php
                    require_once('./php/divErreur.php');
                    ?>
                </form>
            </div>
        </section>
    </main>

    <?php require_once('./templates/end.php'); ?>