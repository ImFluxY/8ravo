<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
<title>Espace créateur - 8ravo</title>
<link rel="stylesheet" href="./css/createur.css">
</head>

<?php if ($user->getTypeIndex() == 0 || $user == null) {
    header('Location: ./no_access.php');
} else {
?>

    <body>
        <?php require_once('./templates/menu.php'); ?>

        <main class="main">
            <section class="createur">
                <div class="createur-container container">
                    <div class="createurEnCours createurCol">
                        <h2 class="createurH2">Modules en cours de création</h2>
                        <?php
                        $cnx = new Base(BASE, USERNAME, PASSWORD);
                        $modulesEnCreation = $cnx->query('SELECT m.id, m.thumbnail, m.title
                        FROM module m
                        WHERE m.idUser = ? AND status =0', array($user->getId()));
                         
                         if($modulesEnCreation == null){ ?>
                            <p>Aucun module en cours de création</p> <?php
                         }else{
                            foreach($modulesEnCreation as $unModuleEncreaction){
                         ?>
                        <div class="exempleDeModule">
                            <div class="createurImage">
                                <img src="<?php echo($unModuleEncreaction['thumbnail'])?>" alt="miniature module" class="createur-img">
                            </div>
                            <div class="createur-titre">
                                <p class="titreC"><?php echo($unModuleEncreaction['title'])?></p>
                                <span class="sousTitreC showPopup" data-url="./templates/popup_creer_module.php">Continuer la création</span>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>

                    <div class="createurEnvoyes createurCol">
                        <h2 class="createurH2">Modules envoyés</h2>

                        <?php
                        $cnx = new Base(BASE, USERNAME, PASSWORD);
                        $modulesEnvoyes = $cnx->query('SELECT m.id, m.thumbnail, m.title, m.status
                        FROM module m
                        WHERE m.idUser = ? AND status != 0', array($user->getId()));
                        
                         if($modulesEnvoyes == null){ ?>
                            <p>Aucun module envoyé</p> <?php
                         }else{
                            foreach($modulesEnvoyes as $unModuleEnvoye){
                                if ($unModuleEnvoye['status'] == 1) {
                                    $etatModule = "En attente";
                                    $etatLink = "<span class='sousTitreC'>Envoyé</span>";
                                } else if ($unModuleEnvoye['status'] == 2) {
                                    $etatModule = "Refusé";
                                    $etatLink = "<span class='sousTitreC showPopup refused' data-url='./templates/popup_infos_module_refuse.php'>Refusé</span>";
                                } else if ($unModuleEnvoye['status'] == 3) {
                                    $etatModule = "Publié";
                                    $etatLink = "<span class='sousTitreC accepted'>Publié</span>";
                                }
                         ?>
                        <div class="exempleDeModule">
                            <div class="createurImage">
                                <img src="<?php echo($unModuleEnvoye['thumbnail'])?>" alt="miniature module" class="createur-img">
                            </div>
                            <div class="createur-titre">
                                <p class="titreC"><?php echo($unModuleEnvoye['title'])?></p>
                                <p id="etatModule" class="sousTitreC">Etat : <?php echo($etatLink)?> | <a href="https://la-projets.univ-lemans.fr/~mmi2pj03/module.php?id=<?php echo($unModuleEnvoye['id'])?>">Voir le module</a></p>
                            </div>
                        </div>
                        <?php }} ?>

                        

                    </div>

                    <div class="createurBoutons createurCol">
                        <h2 class="createurH2">Boutons utiles</h2>
                        <button id="exempleDeBouton" class="createurBtn showPopup" data-url="./templates/popup_creer_module.php">Ecrire un nouveau module</button>
                    </div>
                </div>
            </section>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <?php } ?>

    <?php
    require_once('./templates/end.php');
    ?>