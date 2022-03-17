<?php
require_once('common.php');
require_once('./templates/begin.php');

if ($user == null || $user->getTypeIndex() != 2) {
    header("Location: ./no_access.php");
}

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);

?>
<title>Administrateur Bravo</title>
<link rel="stylesheet" href="./css/administrateur.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main class="main-index">
        <section id="sectionAdmin" class="sectionAdmin">
            <div class="divContainer">
                <div class="divOptions">
                    <h2 class="title">Boutons de module</h2>
                    <div class="listBtnOption">
                        <span class="showPopup btnOption" data-url="./templates/popup_creer_module.php">Écrire un nouveau module</span>
                        <span class="btnOption showPopup" data-url="./templates/popup_modifier_module.php">Modifier un module</span>
                        <span class="showPopup btnOption" data-url="./templates/popup_supprimer_module.php">Supprimer un module</span>
                    </div>
                </div>

                <div class="divCreation">
                    <h2 class="title">Mes modules</h2>
                    <div class="containerCreations">
                        <?php
                        $result = $cnx->query("SELECT title, thumbnail,id, status FROM module WHERE idUser = ?;", array($user->getId()));

                        if (empty($result)) {
                        ?><p>Aucun module en cours de création</p><?php
                                                                } else {
                                                                    foreach ($result as $infos) {
                                                                    ?>
                                <div class="moduleEnCours">
                                    <img src="<?php echo $infos['thumbnail']; ?>" alt="image module" class="imgModule">
                                    <div class="textData">
                                        <h3 class="titleModule"><?php echo $infos['title']; ?></h3>
                                        <?php
                                                                        switch ($infos['status']) {
                                                                            case 0:
                                                                                echo "<p><i>En cours de création</i> | <span class='sousTitreC showPopup lienOrange' data-url='./templates/popup_creer_module.php'>Modifier</span></p>";
                                                                                break;
                                                                            case 1:
                                                                                echo "<p><i>En cours de vérification</i> | <a href='./templates/popup_creer_module.php' class='lienOrange'>Modifier</a></p>";
                                                                                break;
                                                                            case 2:
                                                                                echo "<p><i style='color: red'>Refusé</i> | <span class='sousTitreC showPopup' data-url='./templates/popup_infos_module_refuse.php'>Voir les détails</span> | <span class='sousTitreC showPopup lienOrange' data-url='./templates/popup_creer_module.php'>Modifier</span></p>";

                                                                                
                                                                                break;
                                                                            case 3:
                                                                                echo "<p style='color: green'><i>Publié</i> | <a href='' class='lienOrange'>Modifier</a></p>";
                                                                                break;
                                                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php
                                                                    }
                                                                }
                        ?>
                    </div>
                </div>

                <div class="containerBottom">
                    <div class="divGauche">
                        <div class="divRecus">
                            <h2>Modules reçus</h2>
                            <div class="containerRecu">
                                <?php
                                $result = $cnx->query("SELECT m.title, m.thumbnail, u.firstname, u.lastname FROM moduleRequest r
                                INNER JOIN module m ON r.idModule = m.id
                                INNER JOIN users u ON r.idUser = u.id;");

                                if (empty($result)) {
                                ?><p>Aucun module reçu</p><?php
                                                        } else {
                                                            foreach ($result as $infos) {
                                                            ?>
                                        <div class="moduleRecu">
                                            <img src="<?php echo $infos['thumbnail']; ?>" alt="" class="imgRecu">
                                            <div class="textData">
                                                <h3 class="titleModuleRecu"><?php echo $infos['title']; ?></h3>
                                                <span>
                                                <span class='sousTitreC showPopup lienOrange' data-url='./templates/popup_creer_module.php'>Afficher le module</span>
                                                    |
                                                    <a class="nameUser"><?php echo $infos['firstname'];
                                                                                    echo " ";
                                                                                    echo $infos['lastname']; ?></a>
                                                </span>
                                            </div>
                                        </div>
                                <?php
                                                            }
                                                        }
                                ?>
                            </div>
                        </div>

                        <div class="divDemande">
                            <h2>Demandes pour être créateur</h2>
                            <div class="containerDemand">
                                <?php
                                $result = $cnx->query("SELECT u.id, u.firstname, u.lastname, u.avatar FROM creatorRequest r
                                INNER JOIN users u ON r.idUser = u.id WHERE r.state = 0;");

                                if (empty($result)) {
                                ?><p>Aucune demande de créateur</p><?php
                                                                } else {
                                                                    foreach ($result as $user) {
                                                                    ?>
                                        <div class="demand">
                                            <div class="userProfile">
                                                <img class="avatarUser" alt="avatarUser" src="<?php echo $user['avatar']; ?>">
                                                <div class="infoUser">
                                                    <p href="" class="nomUser"><?php echo $user['firstname'];
                                                                                echo " ";
                                                                                echo $user['lastname']; ?></p>
                                                </div>
                                            </div>
                                            <span class="showPopup" data-url="./templates/popup_demande_createur.php" data-user="<?php echo $user['id'] ?>">Voir la demande</span>
                                        </div>
                                <?php
                                                                    }
                                                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="divGestion">
                        <h2>Gestion des utilisateurs</h2>
                        <div class="search-box">
                            <form class="formSearchUser" id="formSearch">
                                <input class="inputSearchUser" name="search" type="text" id="query" placeholder="Rechercher un utilisateur">
                                <button type="submit" class="btnSearchUser"><svg class="searchSvg" viewBox="0 0 1024 1024">
                                        <path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z">
                                        </path>
                                    </svg></button>
                            </form>
                            <span class="showPopup showBannedUsers" data-url="./templates/popup_liste_bannis.php">Voir les bannis</span>
                        </div>

                        <div class="listUsers">
                        </div>
                    </div>

                </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="./js/search.js"></script>
    <?php require_once('./templates/end.php'); ?>