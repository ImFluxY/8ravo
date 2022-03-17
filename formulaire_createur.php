<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
    <title> "Devenir Créateur Bravo"</title>
    <link rel="stylesheet" href="./css/fromulaire_createur.css" type="text/css" />
</head>

<body>
<?php require_once('./templates/menu.php'); ?>
    <main>
        <?php
        $cnx = new Base(BASE, USERNAME, PASSWORD);
        $deja_fait = $cnx->query("SELECT idRequest, state FROM creatorRequest WHERE idUser = ?", array($user->getId()));

        console_log($deja_fait[0]['state']);

        if ($deja_fait != null) {

            if ($deja_fait[0]['state'] == 0) {?>
            
                <section id="creatorFormulaireFait" class="sectionCreatorFormulaire fait">
                    <div class="divForm">
                        <img src="./img/form_check.svg" class="imgEnvoyee" alt="message envoyée">
                        <h2 class="title">Vous avez déjà fait votre demande.</h2>
                        <p class="patienter">L'équipe <strong>8ravo</strong> a bien reçue votre demande et vous donnera réponse le plus rapidemment possible. <br>Merci de votre compréhension.</p>
                        <a class="btnRetour" href="index.php">Retourner à l'accueil</a>
                    </div>
                </section>

            <?php
            } else if ($deja_fait[0]['state'] == 2) {?>

                <section id="creatorFormulaireFait" class="sectionCreatorFormulaire fait">
                    <div class="divForm">
                        <img src="./img/refuse.png" class="imgEnvoyee" alt="demande refuée">
                        <h2 class="title">Votre demande a été refusée</h2>
                        <p class="patienter">L'équipe <strong>8ravo</strong> vous informe que votre demande pour être créateur a malheuresement été refusée. <br>Merci de retenter votre chance plus tard.</p>
                        <a class="btnRetour" href="index.php">Retourner à l'accueil</a>
                    </div>
                </section>

            <?php }
            else {?>

                <section id="creatorFormulaireFait" class="sectionCreatorFormulaire fait">
                    <div class="divForm">
                        <img src="./img/ok.png" class="imgEnvoyee" alt="demande refuée">
                        <h2 class="title">Vous êtes déjà créateur.</h2>
                        <p class="patienter">Veuillez vous reconnecter pour actualiser votre compte.</p>
                        <a class="btnRetour" href="./deconnexion.php">Se déconnecter</a>
                    </div>
                </section>

           <?php }
        } 
        else {
            
            if (!isset($_POST['valider'])) { ?>
            <section class="sectionFormCrea">
            <div class="formCrea">
                <h2 class="titleFormCrea">Vous n'êtes pas encore créateur?</h2>
                <form class="identifiantFormCrea" method="post">
                    <div class="row firstRow">
                        <div class="col">
                            <label for="nom">Nom</label>
                            <input class="inputFormCrea" name="nom" id="nom" required type="text" value="<?php echo $user->getLastname() ?>" disabled="disabled">
                        </div>
                        <div class="col">
                            <label for="prenom">Prénom</label>
                            <input class="inputFormCrea" name="prenom" id="prenom" required type="text" value="<?php echo $user->getFirstname() ?>" disabled="disabled">
                        </div>
                    </div>

                    <div class="divMessage">
                        <label for="message">Expliquez nous rapidement vos motivations :</label>
                        <textarea class="inputFormCrea textFormCrea" name="message" id="message" required type="text"></textarea>
                        <div class="row zoneCheckbox">
                            <input class="checkboxFormCrea" name="check" id="name" required type="checkbox">
                            <label for="check" class="bloc-conditions">J'accepte les <a href="./mentions_legales.php">conditions générales d'utilisations</a></label>
                        </div>
                    </div>
                    <input class="btnFormCrea" type="submit" id="valider" name="valider" value="Envoyer ma demande pour devenir créateur" />

                    <?php
                        require_once('./php/divErreur.php');
                    ?>
                </form>
            </div>
            
        </section>
        <?php
        }}
        if (isset($_POST['valider'])) {

            $allParamsPresent = isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['message']);
            $id = $user->getId();
            $message = $_POST['message'];

            if ($message === "") {
                error("Tous les champs doivent être remplis.", "formulaire_createur.php");
            }

            try {
                $cnx = new Base(BASE, USERNAME, PASSWORD);

                $cnx->insert(
                    "insert into creatorRequest values (?,?,?,?, ?)",
                    array(null, $id, $message, 0, date("Y-m-d"))
                );
            ?>
                <section id="creatorFormulaireValide" class="sectionCreatorFormulaire ok">
                    <div class="divForm">
                        <img src="./img/message_envoye.svg" class="imgEnvoyee" alt="message envoyée">
                        <h2 class="title">Demande bien envoyé</h2>
                        <a class="btnRetour" href="index.php">Retourner à l'accueil</a>
                    </div>
                </section>
        <?php
            } catch (PDOException $e) {
                error("Un problème est survenu lors de votre demande pour être créateur : " . $e->getMessage() . " " . $e->getTraceAsString(), 'formulaire_createur.php');
            }

            $db = null;
        } else {
        }
        ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <?php
    require_once('./templates/end.php');
    ?>