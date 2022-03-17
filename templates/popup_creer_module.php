<?php
require_once('../common.php');

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);

?>
<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup create">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-menu create" id="start-popup">
            <h1 class="title-popup">Créer un nouveau module</h1>
            <p class="name-creator-title">Rédigé par <strong class="name-creator"><?php $user->getFullName(); ?></strong></p>
            <div class="nav">
                <a href="#module_global" class="fill-nav">Module</a>
                <a href="#module_step1" class="fill-nav">Étape 1</a>
                <a href="#module_step2" class="fill-nav">Étape 2</a>
                <a href="#module_step3" class="fill-nav">Étape 3</a>
                <a href="#module_step4" class="fill-nav">Étape 4</a>
                <a href="#module_step5" class="fill-nav">Étape 5</a>
                <a href="#module_step6" class="fill-nav">Étape 6</a>
                <a href="#module_step7" class="fill-nav">Étape 7</a>
                <a href="#module_step8" class="fill-nav">Étape 8</a>
            </div>
        </div>
        <div class="create-step global" id="module_global" data-module="null">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Partie globale du module</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form id="formAddModule" method="POST" enctype="multipart/form-data">
                <div class="top-data">
                    <div class="left">
                        <div class="input-block">
                            <div class="bloc-label">
                                <label for="title">Titre du module</label>
                                <p class="obligatory" title="Champ obligatoire">*</p>
                            </div>
                            <input type="text" name="title" id="title" class="inputCreate" required>
                        </div>
                        <div class="input-block">
                            <div class="bloc-label">
                                <label for="title">Durée estimée</label>
                                <p class="obligatory" title="Champ obligatoire">*</p>
                            </div>
                            <input type="number" name="duration" id="duration" class="inputCreate" required>
                        </div>
                        <div class="input-block description-module">
                            <div class="bloc-label">
                                <label for="description">Description du module</label>
                                <p class="obligatory" title="Champ obligatoire">*</p>
                            </div>
                            <textarea type="text" name="description" id="description" maxlength="800" cols="50" rows="10" class="inputCreate" required></textarea>
                            <p class="counter description-module">nb / max</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="input-block select">
                            <div class="bloc-label">
                                <label class="select-category" for="category">Catégorie du module</label>
                                <p class="obligatory" title="Champ obligatoire">*</p>
                            </div>
                            <select name="category" id="category-select" class="inputCreate">
                                <option value="no" class="choice-category-text">Choisir une catégorie</option>
                                <?php
                                $categories = $cnx->query("SELECT * FROM moduleCategory");
                                foreach ($categories as $category) {
                                ?>
                                    <option value="<?php echo $category['idCategory']; ?>"><?php echo $category['categoryName']; ?></option>
                                <?php
                                } ?>
                                <option value="new" class="new-categorie-text">Créer une nouvelle catégorie</option>
                            </select>
                            <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                        </div>
                        <div class="input-block new-category disable">
                            <div class="bloc-label">
                                <label for="new-name-category">Nom de la nouvelle catégorie</label>
                                <p class="obligatory none" title="Champ non obligatoire">*</p>
                            </div>
                            <input type="text" name="new-name-category" id="new-name-category" class="inputCreate none" placeholder="Seulement si cette catégorie n'existe pas encore">
                        </div>
                        <div class="input-block">
                            <div class="bloc-label">
                                <label for="image-presentation">Image de présentation du module</label>
                                <p class="obligatory" title="Champ obligatoire">*</p>
                            </div>
                            <input type="file" accept="image/png, image/jpg, image/jpeg, image/gif" name="image" class="input-file" required>
                            <p class="max-size-text">Taille maximale : 5 Mo<br>jpg et png accepté</p>
                            <!--<p class="file-return"></p>-->
                        </div>
                    </div>
                </div>
                <div class="bottom-data">
                    <div class="block-btn-save-step">
                        <input type="submit" value="Enregistrer les informations" class="btn1 btn-save-step">
                    </div>
                    <!-- <button class="next-step">Étape suivante</button> -->
                </div>
            </form>
        </div>
        <div class="create-step" id="module_step1">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 1</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="1">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step2">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 2</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="2">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step3">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 3</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="3">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step4">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 4</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="4">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step5">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 5</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="5">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step6">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 6</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="6">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step7">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 7</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="7">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="create-step" id="module_step8">
            <div class="title-step">
                <div class="title-block">
                    <h2 class="name-step">Étape n° 8</h2>
                    <img src="./img/pen.svg" alt="Crayon de modification" class="pen-modify" title="Modifier la section">
                </div>
                <span class="line"></span>
            </div>
            <form class="data-step" data-index="8">
                <div class="input-block select type-choice">
                    <div class="bloc-label">
                        <label class="select-type" for="type">Type d'étape</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="type" class="inputCreate type-choice">
                        <option value="" class="choice-type-text">Choisir un type d'étape</option>
                        <option value="image">Texte et image</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                        <option value="quiz">Quiz</option>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="form-type-contents"></div>
            </form>
        </div>
        <div class="bloc-over">
            <span class="line"></span>
            <?php
            $userType = $cnx->query("SELECT type FROM users WHERE id = ?", array($user->getId()))[0];

            if ($userType == 1) { ?>
                <div class="bloc-btn-over creator">
                    <button class="btn1 btn-save-later">
                        Terminer plus tard
                    </button>
                    <button class="btn2 btn-send-admin">
                        Faire valider ce module
                    </button>
                </div>
            <?php }

            if ($userType == 1) { ?>
                <div class="bloc-btn-over administrator">
                    <button class="btn1 btn-save-later">
                        Terminer plus tard
                    </button>
                    <button class="btn2 btn-publish-module">
                        Publier ce module
                    </button>
                </div>

            <?php }
            ?>
            <!--
            <div class="bloc-btn-over accept">
                <button class="btn1 btn-refuse">
                    Refuser
                </button>
                <button class="btn2 btn-accept-module">
                    Accepter la publication
                </button>
            </div>
            -->
        </div>
        <!--
        <div class="block-btn-send-reponse">
            <div class="input-block infos-refuse">
                <div class="bloc-label">
                    <label for="infos-refuse">Indications et modifications demandées</label>
                    <p class="obligatory none" title="Champ obligatoire">*</p>
                </div>
                <textarea type="text" name="infos-refuse" id="infos-refuse" maxlength="10000" cols="50" rows="10" class="inputCreate" required></textarea>
            </div>
            <div class="block-btn-send-reponse">
                <input type="submit" value="Envoyer la réponse" class="btn1 btn-send-reponse">
            </div>
        </div>
            -->
    </div>
    <a class="lien-btn-top" href="#start-popup">
        <img src="./img/arrow-top.svg" alt="fleche remonter la page" class="top-arrow" title="Remonter la page">
    </a>
    <script src="./js/modulesManager.js"></script>
</div>