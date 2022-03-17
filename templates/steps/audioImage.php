<div class="text-container container">
    <div class="left">
        <img id="module-img" src="<?php echo $_GET['imageLink']; ?>" alt="" class="text-img">
        <audio id="module-audio" src="<?php echo $_GET['audioLink']; ?>" controls></audio>
        <a href="<?php echo $_GET['sourceAudio']; ?>" target="_blank">Source</a>
    </div>
    <div class="text-data">
        <h1 id="module-title" class="text-title"><?php echo $_GET['title']; ?></h1>
        <p id="module-description" class="text-description"><?php echo $_GET['description']; ?></p>
        <div class="button-zone">
            <button id="button-previous" class="button-text">Retour</button>
            <button id="button-next" class="button-text">Continuer</button>
        </div>
    </div>
</div>