<?php

try {

    $idModule = $_GET["id"];

    $cnx = new Base(BASE, USERNAME, PASSWORD);
    $lignes = $cnx->query('SELECT * FROM module WHERE id=?', array($idModule));

    if (isset($lignes[0])) {
?>
        <section class="home" id="home">
            <div class="home-container container">
                <img src="<?php echo $lignes[0]['mainPicture']; ?>" alt="" class="home-img">
                <div class="home-data">
                    <h1 class="home-title"><?php echo $lignes[0]['title']; ?></h1>
                    <p class="home-description"><?php echo $lignes[0]['description']; ?></p>
                    <button id="button" class="button-home">Commencer</button>
                </div>
            </div>
        </section>
<?php
    } else {
        error("Ce module est introuvable", "index.php");
    }
} catch (PDOException $e) {
    //error("Un problème est survenu lors de votre inscription : ".$e->getMessage()." ".$e->getTraceAsString(),'index.php');
}

?>