<?php
require_once('common.php');
require_once('./templates/begin.php');

//Connection à la base de données et récupération des info du module
$cnx = new Base(BASE, USERNAME, PASSWORD);
$nbModules = $cnx->query("SELECT COUNT(*) AS nbmodules FROM module m WHERE m.status = ?", array("3"));
$nbUsers = $cnx->query("SELECT COUNT(*) AS nbusers FROM users");

?>
<title>Accueil - 8ravo</title>
<link rel="stylesheet" href="./css/index.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main class="main-index">
        <div class="img-particle-cnt img-particle-cnt-1">
            <span class="img-particle img-particle-book"></span>
        </div>
        <div class="img-particle-cnt img-particle-cnt-2">
            <span class="img-particle img-particle-ampule"></span>
        </div>
        <div class="img-particle-cnt img-particle-cnt-3">
            <span class="img-particle img-particle-hat"></span>
        </div>
        <div class="img-particle-cnt img-particle-cnt-4">
            <span class="img-particle img-particle-pen"></span>
        </div>
        <section class="index" id="page-index">
            <div class="index-container">
                <h1>8ravo.</h1>
                <p>Plateforme d’apprentissage en 8 étapes</p>
                <a href="#project-info">
                    <button>
                        Découvrir
                    </button>
                </a>
            </div>
        </section>
        <div class="project-data-cnt" id="project-info">
            <div class="project-data-title">
                <h2>Le projet</h2>
            </div>
            <div class="project-data">
                <div class="project-data-box">
                    <p>8</p>
                    <p>Étapes pour découvrir l'essentiel d'un sujet.</p>
                </div>
                <div class="project-data-box">
                    <p><?php echo $nbModules[0]['nbmodules'] ?></p>
                    <p>Modules publiés
                        sur le site.</p>
                </div>
                <div class="project-data-box">
                    <p><?php echo $nbUsers[0]['nbusers'] ?></p>
                    <p>Utilisateurs inscrits
                        sur le site.</p>
                </div>
            </div>
        </div>

        <div class="discover-module">
            <a href="./modules.php" class="button-disc-module">
                Découvrir les modules
            </a>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <?php
    require_once('./templates/end.php');
    ?>