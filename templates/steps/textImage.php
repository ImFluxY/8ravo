<div class="text-container container">
    <div class="text-item">
        <img id="module-img" src="<?php echo $_GET['imageLink']; ?>" alt="" class="text-img">
        <a href="<?php echo $_GET['sourceImg']; ?>" target="_blank">Source</a>
    </div>
    <div class="text-data">
        <h1 id="module-title" class="text-title"><?php echo $_GET['title']; ?></h1>
        <p id="module-description" class="text-description"><?php echo $_GET['text']; ?></p>
        <div class="button-zone">
            <button id="button-previous" data-prevstep="" class="button-text">Retour</button>
            <button id="button-next" data-nextstep="" class="button-text">Continuer</button>
        </div>
    </div>
</div>