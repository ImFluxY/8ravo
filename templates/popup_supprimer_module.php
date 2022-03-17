<?php
require_once('../common.php');

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);

?>
<div class="popup-main">
    <div class="background_popup"></div>
    <div class="popup delete">
        <img id="popup_close" class="cross" src="./img/cross.svg" alt="croix fermer popup" title="Fermer">
        <div class="popup-content delete">
            <h1 class="title-popup">Supprimer un module</h1>
            <div class="bloc-input-delete">
                <div class="input-block select category-choice-delete">
                    <div class="bloc-label">
                        <label class="select-category-delete" for="category-delete">Catégorie du module</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="category-delete" id="category-delete" class="inputCreate category-choice">
                        <option value="" class="choice-type-text">Choisir la catégorie du module à supprimer</option>
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
                <div class="input-block select name-choice-delete">
                    <div class="bloc-label">
                        <label class="select-name-delete" for="name-delete">Nom du module</label>
                        <p class="obligatory" title="Champ obligatoire">*</p>
                    </div>
                    <select name="name-delete" id="name-delete" class="inputCreate name-choice">
                        <option value="" class="choice-type-text">Choisir le nom du module à supprimer</option>
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
            <div class="bloc-confirm-delete">
                <input type="checkbox" name="confirm-delete" required value="false">
                <label for="confirm-delete" class="text-confirm-delete">En cochant cette case, j'accepte la suppresion immédiate de ce module</label>
            </div>
            <button class="btn2 btn-delete-select-module">Supprimer le module</button>
        </div>
        <script src="./js/modulesManager.js"></script>
    </div>
</div>