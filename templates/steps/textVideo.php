<div class="video-container container">
    <div class="video-item">
        <video controls class="video-img">
            <source id="module-video" src="<?php echo $_GET['videoLink']; ?>" type="video/mp4">
        </video>
        <a href="<?php echo $_GET['sourceVideo']; ?>" target="_blank">Source</a>
    </div>
    <div class="video-data">
        <h1 id="module-title" class="video-title"><?php echo $_GET['title']; ?></h1>
        <p id="module-description" class="video-description"><?php echo $_GET['text']; ?></p>
        <div class="button-zone">
            <button id="button-previous" class="button-text">Retour</button>
            <button id="button-next" class="button-text">Continuer</button>
        </div>
    </div>
</div>