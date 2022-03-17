<?php
require_once('../common.php'); ?>

<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup banned">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-content banned">
            <h1 class="title-popup">Liste des bannis</h1>
            <div class="bloc-search banned">

            </div>
            <div class="listUsers banned">
                <?php $cnx = new Base(BASE, USERNAME, PASSWORD);
                $listeBannis = $cnx->query('SELECT u.id, u.firstname, u.lastname, u.avatar, u.type
                FROM users u
                WHERE banned = 1 ORDER BY u.firstname');
                 if ($listeBannis == null) { ?>
                    <p>Aucun utilisateur n'est banni.</p> <?php
                } else {
                foreach ($listeBannis as $unBannis) {?>
                    <?php
                        if ($unBannis['type'] == 0) {
                            $role = "Membre";
                        } else if ($unBannis['type'] == 1) {
                            $role = "Créateur";
                        }
                    ?>
                        <div class="userOptions">
                            <div class="userGestion">
                                <img class="avatarUser" alt="avatarUser" src="<?php echo ($unBannis['avatar']) ?>">
                                <div class="infoUser">
                                    <p class="nomUser"><?php echo ($unBannis['firstname'] . " " . $unBannis['lastname']) ?></p>
                                    <p class="roleUser"><?php echo ($role) ?></p>
                                </div>
                            </div>
                            <button data-user="<?php echo ($unBannis['id']) ?>" data-action="unbann" class="btn2 btn-unban">Débannir</button>
                        </div>
                <?php }
                }
                echo "<script src='./js/usersManager.js'></script>";
                ?>
            </div>
        </div>
    </div>
</div>