<?php
require_once('../common.php');

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);

?>
<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup modify">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-content modify">
            <h1 class="title-popup">Modifier un module</h1>
            <div class="bloc-input-modify">
                <div class="input-block select category-choice-modify">
                    <div class="bloc-label">
                        <label class="select-category-modify" for="category-modify">Catégorie du module</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="category-modify" id="category-modify" class="inputCreate category-choice">
                        <option value="" class="choice-type-text">Choisir la catégorie du module à modifier</option>
                        <option value="">Toutes les catégories</option>
                        <?php
                        $categories = $cnx->query("SELECT * FROM moduleCategory");

                        if (empty($categories)) {
                        ?><option value="no">Aucune catégorie</option><?php
                                                                } else {
                                                                    foreach ($categories as $category) {
                                                                    ?>
                                <option value="<?php echo $category['idCategory']; ?>"><?php echo $category['categoryName']; ?></option>
                        <?php
                                                                    }
                                                                } ?>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
                <div class="input-block select name-choice-modify">
                    <div class="bloc-label">
                        <label class="select-name-modify" for="name-modify">Nom du module</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="name-modify" id="name-modify" class="inputCreate name-choice">
                        <option value="" class="choice-type-text">Choisir le nom du module à modifier</option>
                        <?php
                        $modules = $cnx->query("SELECT id, title FROM module");

                        if (empty($modules)) {
                        ?><option value="no">Aucune catégorie</option><?php
                                                                } else {
                                                                    foreach ($modules as $module) {
                                                                    ?>
                                <option value="<?php echo $module['id']; ?>"><?php echo $module['title']; ?></option>
                        <?php
                                                                    }
                                                                } ?>
                    </select>
                    <img src="./img/arrow.svg" alt="Fleche selection liste" class="arrow-select">
                </div>
            </div>
            <button class="btn2 btn-modify-select-module">Modifier le module</button>
        </div>
        <script src="./js/modulesManager.js"></script>
    </div>
</div>