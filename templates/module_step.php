<?php

//Récupération de l'id du module
if(isset($_GET["id"])){
    $idModule = $_GET["id"];
}else{
    header("Location: ./404.php");
}  

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);
$lignes = $cnx->query('SELECT * FROM module WHERE id=?', array($idModule));

?>
<section class="text" id="module-step" data-module="<?php echo $idModule; ?>">
</section>
<script src="./js/note.js"></script>