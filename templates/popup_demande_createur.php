<?php
require_once('../common.php');

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);
console_log($_POST);
$result = $cnx->query("SELECT u.firstname, u.lastname, u.email, u.birthDate, c.text
FROM users u
INNER JOIN creatorRequest c ON c.idUser = u.id
WHERE u.id = ?", array($_POST['user']));

if (isset($_POST['refuser'])) {

    // Envoi d'un mail pour avertir du refus de la demande créateur
    $msg  =
    '
    <html>
        <div style="margin: 18px auto; display: flex; flex-direction: column; justify-content: center;">
            <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/logo_mail_auto.png")).'" alt="logo 8ravo" style="width: 100px; margin: 20px auto;">
            <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/illustration_8ravo.png")).'" alt="Illustration Bravo ordinateur et utilisateurs" style="width: 200px; margin: 25px auto;">
            <h1 style="font-size: 35px; color: #FF7F00; font-weight: bold; justify-self: center; margin: 20px auto">Votre demande créateur !</h1>
            <p style="font-size: 20px; margin: 20px auto 5px auto; justify-self: center;">Bonjour, suite à votre demande pour devenir créateur, nous sommes dans le regret de vous annoncer que celle-ci a été rejetée. Pour obtenir plus d\'informations, veuillez nous contacter.</p>
            <p style="font-size: 20px; margin: 15px auto 0; justify-self: center;">Cordialement,</p>
            <p style="font-size: 20px; margin: 0 auto 20px; justify-self: center;">L\'équipe 8ravo.</p>
            <a style="margin: 45px auto; text-align: center; padding: 10px 15px; background-color: #FF7F00; color: white; font-size: 20px; text-decoration: none; display: inline-block; justify-self: center;" href="https://la-projets.univ-lemans.fr/~mmi2pj03/contact.php">Nous contacter</a>
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

    mail($result[0]['email'], "Votre demande pour être créateur", $msg, implode("\r\n", $headers));

} else if (isset($_POST['accepter'])) {

    // Envoi d'un mail pour avertir de l'acceptation de la demande créateur
    $msg  =
    '
    <html>
        <div style="margin: 18px auto; display: flex; flex-direction: column; justify-content: center;">
            <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/logo_mail_auto.png")).'" alt="logo 8ravo" style="width: 100px; margin: 20px auto;">
            <img src="data:image/png;base64,'.base64_encode(file_get_contents("./img/illustration_8ravo.png")).'" alt="Illustration Bravo ordinateur et utilisateurs" style="width: 200px; margin: 25px auto;">
            <h1 style="font-size: 35px; color: #FF7F00; font-weight: bold; justify-self: center; margin: 20px auto">Votre demande créateur !</h1>
            <p style="font-size: 20px; margin: 20px auto 0 auto; justify-self: center;">Féliciattion !</p>
            <p style="font-size: 20px; margin: 0 auto; justify-self: center;">L\'équipe 8ravo a le plaisir de vous annoncer que votre demande pour devenir créateur a été acceptée.</p>
            <p style="font-size: 20px; margin: 0 auto 5px auto; justify-self: center;">Vous pouvez donc dès maintenant commencer à écrire vos propres modules grâce à votre espace créateur.</p>
            <p style="font-size: 20px; margin: 15px auto 0; justify-self: center;">Cordialement,</p>
            <p style="font-size: 20px; margin: 0 auto 20px; justify-self: center;">L\'équipe 8ravo.</p>
            <a style="margin: 45px auto; text-align: center; padding: 10px 15px; background-color: #FF7F00; color: white; font-size: 20px; text-decoration: none; display: inline-block; justify-self: center;" href="https://la-projets.univ-lemans.fr/~mmi2pj03/createur.php">Espace créateur</a>
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

    mail($result[0]['email'], "Votre demande pour être créateur", $msg, implode("\r\n", $headers));
}
?>

<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup demande">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-content demande">
            <h1 class="title-popup">Demande créateur</h1>
            <div class="bloc-infos-user-demande">
                <div class="info-user">
                    <h3>Nom</h3>
                    <p class="case"><?php echo $result[0]['lastname'] ?></p>
                </div>
                <div class="info-user">
                    <h3>Prénom</h3>
                    <p class="case"><?php echo $result[0]['firstname'] ?></p>
                </div>
                <div class="info-user">
                    <h3>Mail</h3>
                    <p class="case"><?php echo $result[0]['email'] ?></p>
                </div>
                <div class="info-user">
                    <h3>Date de naissance</h3>
                    <p class="case"><?php echo $result[0]['birthDate'] ?></p>
                </div>
            </div>
            <div class="bloc him-explain">
                <h3>"Pourquoi moi ?"</h3>
                <p class="case"><?php echo $result[0]['text'] ?></p>
            </div>
            <div class="block-btn-demande">
            <button data-user="<?php echo ($_POST['user']) ?>" data-action="refuserDemande" class="btn1 btn-refuse-demande" id="refuserDemande" name="refuserDemande" >Refuser la demande</button>
            <button data-user="<?php echo ($_POST['user']) ?>" data-action="accepterDemande" class="btn2 btn-accept-demande" id="accepterDemande" name="accepterDemande" >Accepter la demande</button>
                <button data-user="<?php echo ($_POST['user']) ?>" data-action="bannirUSer" class="btn-ban" type="submit" id="bannirUSer" name="bannirUSer" >Bannir ce membre</button>

            </div>
            <?php echo "<script src='./js/usersManager.js'></script>"; ?>
        </div>
    </div>
</div>