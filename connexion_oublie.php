<?php
require_once("common.php");
require_once('./templates/begin.php');
?>

<?php
if (isset($_POST['valider'])) {

    $allParamsPresent = isset($_POST['email']) && isset($_POST['token']) && isset($_POST['password1']) && isset($_POST['password2']);

    $email = $_POST['email'];
    $token = $_POST['token'];
    $mdp1 = $_POST['password1'];
    $mdp2 = $_POST['password2'];

    //Authentification via le token
    $user = UserModel::authToken($email, $token);
    if ($user == null) {
        error(
            "L'identifiant ou le mot de passe est incorrect",
            "connexion_oublie.php"
        );
    } else {
        $_SESSION['user'] = $user;
        header("Location: ./index.php");


        if ($email === "" || $token === "" || $mdp1 === "" || $mdp2 === "") {
            error("Tous les champs doivent être remplis.", "connexion_oublie.php");
        }

        if ($mdp1 != $mdp2) {
            error("Les deux mots de passe ne sont pas identiques.", "connexion_oublie.php");
        }

        $mdplenght = mb_strlen($_POST['password1']);
        if ($mdplenght < 6) {
            error("Le mot de passe doit contenir au moins 6 caractères.", "connexion_oublie.php");
        }

        try {
            $cnx = new Base(BASE, USERNAME, PASSWORD);

            $cnx->update(
                "UPDATE users
        SET password = ?,
        token = null
        WHERE email = ?",
                array(sha1($mdp1), $email)
            );
            $_SESSION['user'] = $user;
            header("Location:./index.php");
        } catch (PDOException $e) {
            error("Un problème est survenu lors de votre connexion : " . $e->getMessage() . " " . $e->getTraceAsString(), 'connexion_oublie.php');
        }
        $db = null;
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
                <h2 class="title">Réinitialisation du mot de passe</h2>
                <form action="" id="formulaire" class="contactForm" method="post">
                    <div class="row firstRow">
                        <div class="col">
                            <label for="email">E-mail</label>
                            <input class="inputContact" name="email" id="email" type="email" required>
                            <label for="token">Code de vérifiacation</label>
                            <input class="inputContact" type="text" id="token" name="token" required>

                            <label for="password1">Nouveau mot de passe</label>
                            <input class="inputContact" type="password" id="password1" required name="password1" placeholder="Minimum 6 caractères">

                            <label for="password2">Confirmer le mot de passe</label>
                            <input class="inputContact" type="password" id="password2" required name="password2">
                        </div>
                    </div>

                    <div class="connect-button">
                        <input class="btnConnexion connectOublie" type="submit" id="valider" name="valider" value="→ Se connecter" />
                    </div>
                    <?php
                    require_once('./php/divErreur.php');
                    ?>
                </form>
            </div>
        </section>
    </main>

    <?php require_once('./templates/end.php'); ?>