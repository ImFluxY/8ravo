<?php
require_once("common.php");
require_once('./templates/begin.php');
?>

<?php
if (isset($_POST['valider'])) {

    $allParamsPresent = isset($_POST['password0']) && isset($_POST['password1']) && isset($_POST['password2']);

    $mdp0 = $_POST['password0'];
    $mdp1 = $_POST['password1'];
    $mdp2 = $_POST['password2'];
    $email = $user->getEmail();

    //Authentification via l'ancien mdp et l'email de l'user (dans la session)
    $user = UserModel::auth($email, $mdp0);
    if ($user == null) {
        error(
            "L'ancien mot de passe est incorrect",
            "modification_mdp.php"
        );
    } else {
        $_SESSION['user'] = $user;
        header("Location: ./compte.php");

        if ($mdp0 === "" || $mdp1 === "" || $mdp2 === "") {
            error("Tous les champs doivent être remplis.", "modification_mdp.php");
        }

        if ($mdp1 != $mdp2) {
            error("Les deux mots de passe ne sont pas identiques.", "modification_mdp.php");
        }

        $mdplenght = mb_strlen($_POST['password1']);
        if ($mdplenght < 6) {
            error("Le mot de passe doit contenir au moins 6 caractères.", "modification_mdp.php");
        }

        try {
            $cnx = new Base(BASE, USERNAME, PASSWORD);

            $cnx->update(
                "UPDATE users
                SET password = ?
                WHERE email = ?",
                array(sha1($mdp1), $email)
            );
            $_SESSION['user'] = $user;

            /// Envoi d'un mail pour avertir de l'incription
            $msg  =
                '
                <html>
                    <div style="margin: 18px auto; display: flex; flex-direction: column; justify-content: center;">
                        <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/logo_mail_auto.png")).'" alt="logo 8ravo" style="width: 100px; margin: 20px auto;">
                        <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/illustration_8ravo.png")).'" alt="Illustration Bravo ordinateur et utilisateurs" style="width: 200px; margin: 25px auto;">
                        <h1 style="font-size: 35px; color: #FF7F00; font-weight: bold; justify-self: center; margin: 20px auto">Votre mot de passe a été changé !</h1>
                        <p style="font-size: 20px; margin: 20px auto 0 auto; justify-self: center;">Si vous venez de changer votre mot de passe, ne tenez pas compte de ce mail.</p>
                        <p style="font-size: 20px; margin-top: 25px; margin: 0 auto; justify-self: center;">Votre mot de passe vient d\'être changé, si vous n\'êtes pas à l\'origine de cette modification, merci de contacter notre service.</p>
                        <a style="margin: 50px auto; text-align: center; padding: 10px 15px; background-color: #FF7F00; color: white; font-size: 20px; text-decoration: none; display: inline-block; justify-self: center;Z" href="https://la-projets.univ-lemans.fr/~mmi2pj03/contact.php">Nous contacter</a>
                    </div>
                    <footer style="margin-top: 50px;">
                        <p style="text-align: center; font-size: 16px; color: #D4D4D4">Ceci est un message automatique, merci de ne pas y répondre.</p>
                    </footer>
                </html>
            ';

            $mail_8ravo = "projets-mmi@univ-lemans.fr";

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            $headers[] = 'From: 8ravo <' . $mail_8ravo . '>' . "\r\n";

            mail($email, "Mot de passe modifié", $msg, implode("\r\n", $headers));

            header("Location:./compte.php");
            console_log("mdp atualisé");
        } catch (PDOException $e) {
            error("Un problème est survenu lors du changement de mot de passe: " . $e->getMessage() . " " . $e->getTraceAsString(), 'modification_mdp.php');
        }
       
    }
}

?>

<link rel="stylesheet" href="./css/contact.css" type="text/css" />
<link rel="stylesheet" href="./css/connexion.css" type="text/css" />
<title> "Connexion Bravo"</title>
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main>
        <section id="connexion" class="sectionConnexion">
            <div class="divForm">
                <h2 class="title">Changement du mot de passe</h2>
                <form action="" id="formulaire" class="contactForm" method="post">
                    <div class="row firstRow">
                        <div class="col">

                            <label for="password0">Ancien mot de passe</label>
                            <input class="inputContact" type="password" id="password0" required name="password0">

                            <label for="password1">Nouveau mot de passe</label>
                            <input class="inputContact" type="password" id="password1" required name="password1" placeholder="Minimum 6 caractères">

                            <label for="password2">Confirmer le mot de passe</label>
                            <input class="inputContact" type="password" id="password2" required name="password2">
                        </div>
                    </div>

                    <div class="options">
                        <p class="optionLigne">Mot de passe oublié? <a class="boldLink" href="mdp_oublie.php">Cliquez ici</a></p>
                    </div>

                    <div class="connect-button">
                        <input class="btnConnexion connectOublie" type="submit" id="valider" name="valider" value="→ Enregistrer" />
                    </div>
                    <?php
                    require_once('./php/divErreur.php');
                    ?>
                </form>
            </div>
        </section>
    </main>

    <?php require_once('./templates/end.php'); ?>