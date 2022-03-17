<?php
require_once('common.php');

?>

<header>
    <nav class="nav-website">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="./index.php" class="logo" title="Accueil">8ravo</a>
        <ul>
            <li><a href="./index.php#page-index">Accueil</a></li>
            <li><a href="./modules.php">Modules</a></li>
            <li><a href="./contact.php">Contact</a></li>
        
            <?php
            if (isset($user)) {
                if ($user->getTypeIndex() == 2) {
            ?>
                    <li><a href="./administrateur.php">Administrateur</a></li>
                    </ul>
                    <ul class="bloc">
                <?php
                }
                if ($user->getTypeIndex() == 1) {
                ?>
                    <li><a href="./createur.php">Créer</a></li>
                    </ul>
                    <ul class="bloc">
                <?php
                }
                if ($user->getTypeIndex() == 0) {
                    ?>
                        <li><a href="./devenir_createur.php">Créer</a></li>
                        </ul>
                        <ul class="bloc">
                    <?php
                    }
                ?>
                <div class="hide-2">
                    <div class="account-data">
                        <a href="compte.php">
                            <img src="<?php echo ($user->getAvatar()); ?>" alt="Avatar du profil <?php echo $user->getFullName(); ?>" class="avatar">
                            <div class="account-name">
                                <p><?php echo $user->getFullName(); ?></p>
                                <span><?php echo $user->getTypeName(); ?></span>
                            </div>
                        </a>
                    </div>
                    <a href="./deconnexion.php" class="a-disco">
                        <img src="./img/disconnect.png" alt="Porte se déconnecter" class="img-disco" title="Se déconnecter">
                    </a>
                </div>
            <?php
            } else {
            ?>
                </ul>
                <ul class="bloc">
                <div class="hide-1">
                    <li><a class="log-in" href="./connexion.php">Connexion</a></li>
                    <li><a class="sign-in" href="./inscription.php">Inscription</a></li>
                </div>
            <?php
            }
            ?>
        </ul>
    </nav>
</header>