<?php
require_once('common.php');
require_once('./templates/begin.php');

?>
<title>Compte - 8ravo</title>
<link rel="stylesheet" href="./css/profil.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<?php if ($user == null) {
    header('Location: ./connexion.php');
} else {
?>

    <body>
        <?php require_once('./templates/menu.php');
        $cnx = new Base(BASE, USERNAME, PASSWORD);

        echo "fekzfoez";

        // script de modifications des infos de utilisateur
        if (isset($_POST['btnValideNomPrenomProfile'])) {

            $id = $user->getId();
            $oldFirstname = $user->getFirstname();
            $oldLaststname = $user->getLastname();
            $firstname = $_POST['prenomProfile'];
            $lastname = $_POST['nomProfile'];

            $email = $user->getEmail();
            $birthdate = $user->getBirthdate();
            $type = $user->gettype();
            $banned = $user->getBanned();

            //Avatar
            $avatar = "./img/avatars/avatar_default.jpg";
            $oldAvatar = $user->getAvatar();

            //Test avec des console.log
            console_log($lastname . " " . $firstname . " " . $id);

            if (!empty($_POST["prenomProfile"]) && !empty($_POST['nomProfile'])) {
                console_log("Nom et prénom modifiés");
                $user->update($id, $firstname, $lastname, $email, $birthdate, $type, $banned, $oldAvatar);
            } else if (!empty($lastname)) {
                console_log("Nom modifié");
                $user->update($id, $oldFirstname, $lastname, $email, $birthdate, $type, $banned, $oldAvatar);
            } else if (!empty($firstname)) {
                console_log("Prénom modifié");
                $user->update($id, $firstname, $oldLaststname, $email, $birthdate, $type, $banned, $oldAvatar);
            }
            /* MODIFICATION DE L'AVATAR
        else if (!empty($avatar)) {
                console_log("Avatar modifié");
                $user->update($id, $oldFirstname, $oldLaststname, $email, $birthdate, $type, $banned, $avatar);
            } 
            */ else {
                console_log("Aucune modification");
            }
            $_SESSION['user'] = $user;
            header("Location:./compte.php");
            //header("Refresh:0");
        }

        ?>

        <main class="main">
            <section class="profile">
                <form action="" class="profilePrincipale pseudoFormulaire" method="post" enctype="multipart/form-data">
                    <div class="enteteProfile">
                        <div class="divImgProfil" id="bouttonImgProfile">
                            <input type="file" accept="image/png, image/jpg, image/jpeg, image/gif" name="image" class="btn-modify-avtar" value="Modifier l'avatar"></input>
                            <img src="<?php echo ($user->getAvatar()) ?>" class="imgProfile">

                        </div>
                        <div class="titreProfile">
                            <p class="pseudoProfile" id="pseudoProfile"><?php echo $user->getFullName(); ?></p>
                            <p class="roleProfile" id="roleProfile"><?php echo $user->getTypeName(); ?></p>
                        </div>
                    </div>
                    <div class="infosProfile">
                        <div class="formulaireProfile">
                            <div class="nomPrenomProfile">
                                <div class="caseProfile caseProfileNom">
                                    <label class="labelProfil" for="nomProfile">Nom</label>
                                    <input type="text" class="barreTextProfile inputProfile" id="nomProfile" name="nomProfile" placeholder="<?php echo ($user->getLastname()) ?>">
                                </div>
                                <div class="caseProfile caseProfilePrenom">
                                    <label class="labelProfil" for="prenomProfile">Prenom</label>
                                    <input type="text" class="barreTextProfile inputProfile" id="prenomProfile" name="prenomProfile" placeholder="<?php echo ($user->getFirstname()) ?>">
                                </div>
                            </div>
                            <div class="caseProfile caseProfileEmail">
                                <p>Mail</p>
                                <div class="barreTextProfile">
                                    <?php echo $user->getEmail(); ?>
                                </div>
                            </div>
                            <div class="dateMdpProfile">
                                <div class="caseProfile caseProfileDate">
                                    <p>Date de naissance</p>
                                    <div class="barreTextProfile">
                                        <?php echo ($user->getBirthdate()) ?>
                                    </div>
                                </div>
                                <div class="caseProfile caseProfileMdp">
                                    <div class="textMdpProfile">
                                        <p>Mot de passe</p>
                                        <div id="modifMdp"><a href="./modification_mdp.php" class="lienModifMdp">
                                                <p>Modifier</p>
                                            </a></div>
                                    </div>
                                    <div class="barreTextProfile">
                                        ************
                                    </div>
                                </div>
                            </div>
                            <div class="divBtnProfile">
                                <button type="submit" class="btnProfile" id="btnValideNomPrenomProfile" name="btnValideNomPrenomProfile">Enregistrer les modifications</button>
                            </div>
                        </div>

                        <div class="notificationsProfile">
                            <?php $demandeCreateur = $cnx->query('SELECT c.idUser, c.idRequest, c.text, c.state, c.dateRequest
                            FROM creatorRequest c
                            WHERE idUser = ?', array($user->getId()));

                            if ($demandeCreateur == null) {
                            } else {
                                if ($demandeCreateur[0]['state'] == 0) {
                                    $etatDemande = "en attente";
                                } else if ($demandeCreateur[0]['state'] == 1) {
                                    $etatDemande = "acceptée";
                                } else if ($demandeCreateur[0]['state'] == 2) {
                                    $etatDemande = "refusée";
                                }
                            ?>
                                <div class="notifProfile">
                                    <img src="./img/bell.svg">
                                    <div>
                                        <p>Votre demande de créateur est <strong><?php echo ($etatDemande) ?></strong></p>
                                    </div>
                                    <p class="dateNotif"><?php echo ($demandeCreateur[0]['dateRequest']) ?></p>
                                </div>
                            <?php } ?>

                            <?php $modulesRequests = $cnx->query('SELECT r.idUser, r.idRequest, r.idModule, r.dateRequest, m.title, m.status
                            FROM moduleRequest r
                            INNER JOIN module m  ON m.id = r.idModule
                            WHERE r.idUser = ?', array($user->getId()));

                            if ($modulesRequests == null) {
                                console_log("Pas de demande de module");
                            } else {

                                foreach ($modulesRequests as $uneRequete) {

                                    if ($uneRequete['status'] == 0) {
                                        $etatModule = "en cours de création";
                                    } else if ($uneRequete['status'] == 1) {
                                        $etatModule = "en attente";
                                    } else if ($uneRequete['status'] == 2) {
                                        $etatModule = "refusé";
                                    } else if ($uneRequete['status'] == 3) {
                                        $etatModule = "publiée";
                                    }
                            ?>
                                    <div class="notifProfile">
                                        <img src="./img/bell.svg">
                                        <div>
                                            <p>Votre module "<?php echo substr($uneRequete['title'], 0, 13) . '...' ?>" est <strong><?php echo ($etatModule) ?> </strong> <a href="./createur.php">voir plus</a></p>
                                        </div>
                                        <p class="dateNotif"><?php echo ($uneRequete['dateRequest']) ?></p>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </form>


                <div class="modulesProfile">
                    <?php
                    //Création d'une ligne Modules en cours si l'utilisateur en a
                    $modulesEnCours = $cnx->query('SELECT c.idModule, m.thumbnail, c.userCompleted
                        FROM completed c
                        INNER JOIN module m ON m.id = c.idModule
                        WHERE c.idUser = ? AND c.userCompleted < 9', array($user->getId()));
                        ?>
                        <div class="lignesProfilModule">
                            <h2 class="profileH2">Modules en cours</h2>
                            <div class="imagesModule">
                            <?php
                    if ($modulesEnCours == null) { ?>
                        <p>Aucun module en cours de lecture</p> <?php
                    }else{
                    ?>
                        
                                <?php
                                foreach ($modulesEnCours as $unModuleEnCours) {
                                ?>
                                    <div class="exempleImgModule" title="Voir le module">
                                        <div class="profilModuleCadreImg">
                                            <a href="./module.php?id= <?php echo ($unModuleEnCours['idModule']) ?>">
                                                <img src="<?php echo ($unModuleEnCours['thumbnail']) ?>" alt="" class="profilModuleImg">
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }}
                                ?>
                            </div>
                        </div>
                        <div class="lignesProfilModule">
                    <h2 class="profileH2">Modules terminés</h2>
                    <div class="imagesModule">
                        <?php
                    //Création d'une ligne Modules Terminés si l'utilisateur en a
                    $modulesTermines = $cnx->query('SELECT c.idModule, m.thumbnail, c.userCompleted
                        FROM completed c
                        INNER JOIN module m ON m.id = c.idModule
                        WHERE c.idUser = ? AND c.userCompleted = 9', array($user->getId()));
                    if ($modulesTermines == null) { ?>
                        <p>Aucun module terminé</p> <?php
                    }else{
                    ?>
                                <?php
                                foreach ($modulesTermines as $unModulesTermine) {
                                ?>
                                    <div class="exempleImgModule" title="Voir le module">
                                        <div class="profilModuleCadreImg">
                                            <a href="./module.php?id= <?php echo ($unModulesTermine['idModule']) ?>">
                                                <img src="<?php echo ($unModulesTermine['thumbnail']) ?>" alt="" class="profilModuleImg">
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }}
                                ?>
                            </div>
                        </div>

                        <div class="lignesProfilModule">
                            <h2 class="profileH2">Notes</h2>
                            <div class="imagesModule">
                    <?php
                    $notesModulesUser = $cnx->query('SELECT m.thumbnail, g.moduleGrade, g.idModule, g.idUser
                        FROM grade g
                        INNER JOIN module m ON m.id = g.idModule
                        WHERE g.idUser = ?', array($user->getId()));
                    if ($notesModulesUser == null) { ?>
                        <p>Aucune note attribuée</p> <?php
                    }else{
                    ?>
                                <?php
                                foreach ($notesModulesUser as $uneNoteModuleUser) {
                                ?>
                                    <div class="exempleImgModule" title="Voir le module">
                                        <div class="profilModuleCadreImg">
                                            <a class="lienModule" href="./module.php?id= <?php echo ($uneNoteModuleUser['idModule']) ?>">
                                                <img src="<?php echo ($uneNoteModuleUser['thumbnail']) ?>" alt="" class="profilModuleImg">
                                                <p class="noteProfile"><?php echo ($uneNoteModuleUser['moduleGrade']) ?></p>
                                            </a>
                                        </div>
                                    </div>
                                <?php }} ?>
                            </div>
                        </div>
                </div>

                <?php
                require_once('./php/divErreur.php');
                ?>
            </section>
        </main>
    <?php }
    ?>
    <script src="./js/profil.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <?php
    require_once('./templates/end.php');
    ?>