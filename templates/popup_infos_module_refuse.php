<?php require_once('../common.php');
$cnx = new Base(BASE, USERNAME, PASSWORD);
$demandeCreateur = $cnx->query('SELECT r.idModule,r.explicationRefus, r.idUser, m.id, m.title
FROM moduleRequest r
INNER JOIN module m ON m.id = r.idModule
WHERE r.idUser = ?', array($user->getId()));
console_log($demandeCreateur);

?>
<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup refuse">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-content refuse">
            <h1 class="title-popup">Module refusé</h1>
            <div class="bloc-infos-user-demande">
                <h3>Titre du module</h3>
                <p class="case"><?php echo($demandeCreateur[0]['title'])?></p>
            </div>
            <div class="bloc him-explain">
                <h3>Retour et explications</h3>
                <p class="case"><?php echo($demandeCreateur[0]['explicationRefus'])?></p>
            </div>
            <input class="btn2 btn-voir_moudle_refuse" type="submit" id="voirModule" name="voirModule" value="Voir le module">
        </div>
    </div>
</div>