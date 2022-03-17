<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
<link rel="stylesheet" href="./css/mdp_oublie.css" type="text/css" />
<link rel="stylesheet" href="./css/contact.css" type="text/css" />

<title>Mot de passe oublié - 8ravo</title>
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main>
        <?php
        if (!isset($_POST['valider'])) { ?>
            <section id="contact" class="sectionMdpOublie">
                <div class="container">
                    <h2 class="title">Mot de passe oublié</h2>
                    <form action="" id="formulaire" class="mdpOublieForm" method="post">
                        <div class="infoInput">
                            <label for="email">Rentrez votre adresse mail</label>
                            <input class="inputEmail" name="email" id="email" required type="email">
                        </div>
                        <input class="btnForm" type="submit" id="valider" name="valider" value="Valider" />
                    </form>
                    <?php
                    require_once('./php/divErreur.php');
                    ?>
                </div>
            </section>

            <?php
        }
        if (isset($_POST['valider'])) {

            $allParamsPresent = isset($_POST['email']);
            $email = $_POST['email'];

            if ($email === "") {
                error("Tous les champs doivent être remplis.", "mdp_oublie.php");
            }

            try {
                $cnx = new Base(BASE, USERNAME, PASSWORD);

                $idUser = $cnx->query(
                    "SELECT id FROM users WHERE email = ?",
                    array($email)
                );

                if ($idUser == null) {
                    error("Veuillez entrer une adresse mail valide.", "mdp_oublie.php");
                } else {
            ?>
                    <section id="contactValide" class="sectionContact">
                        <div class="divForm">
                            <img src="./img/message_envoye.svg" class="imgEnvoyee" alt="message envoyée">
                            <h2 class="title">Vérifiez vos mails.</h2>
                            <a class="btnRetour" href="index.php">Retourner à l'accueil</a>
                        </div>
                    </section>

                <?php
                    //Générer un TOKEN et le rentrer dans la BDD
                    $comb = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array();
                    $combLen = strlen($comb) - 1;
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $combLen);
                        $pass[] = $comb[$n];
                    }
                    $token = implode($pass);

                    $cnx->update(
                        "UPDATE users
                    SET token = ? 
                    WHERE email = ?",
                        array($token, $email)
                    );

                    // the message

                    /// Envoi d'un mail pour avertir de l'incription
                    $msg  =
                        '
                        <html>
                            <div style="margin: 18px auto; display: flex; flex-direction: column; justify-content: center;">
                                <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/logo_mail_auto.png")).'" alt="logo 8ravo" style="width: 100px; margin: 20px auto;">
                                <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/illustration_8ravo.png")).'" alt="Illustration Bravo ordinateur et utilisateurs" style="width: 200px; margin: 25px auto;">
                                <h1 style="font-size: 35px; color: #FF7F00; font-weight: bold; justify-self: center; margin: 20px auto">Récupération de votre mot de passe !</h1>
                                <p style="font-size: 20px; margin-top: 25px; margin: 25px auto 0 auto; justify-self: center;">Vous avez perdu votre mot de passe ?</p>
                                <p style="font-weight: 700; font-size: 20px; margin: 0 auto 25px auto; justify-self: center;">Copier ce code et suivez le lien</p>
                                <p style="margin: 40px auto; text-align: center; padding: 10px 25px; border: 2px solid #FF7F00; color: black; font-size: 30px; text-decoration: none; background-color: #FFD6AE; letter-spacing: 10px; border-radius: 15px; max-width: 275px; justify-self: center;">' .$token. '</p>
                                <a style="margin: 50px auto; text-align: center; padding: 10px 15px; background-color: #FF7F00; color: white; font-size: 20px; text-decoration: none; display: inline-block; justify-self: center;Z" href="https://la-projets.univ-lemans.fr/~mmi2pj03/connexion_oublie.php">Changer mon mot de passe</a>
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

                    // send email
                    mail($email, "Mot de passe oublié", $msg, implode("\r\n", $headers));
                }
                ?>

        <?php
            } catch (PDOException $e) {
                error("Un problème est survenu : " . $e->getMessage() . " " . $e->getTraceAsString(), 'mdp_oublie.php');
            }

            $db = null;
        } else {
        }
        ?>
    </main>
    <?php require_once('./templates/end.php'); ?>