<div class="quiz-container container">
    <div class="quiz" data-quiz="<?php echo $_GET['infos']['idQuiz']; ?>">
        <div class="quiz-data">
            <h1 id="module-title" class="quiz-title"><?php echo $_GET['infos']['title']; ?></h1>
            <p id="module-description" class="quiz-description"><?php echo $_GET['infos']['description']; ?></p>
        </div>
        <div id="quiz-content">
            <?php
            foreach ($_GET['questions'] as $infosQuestion) {
            ?>
                <div class="quiz-row">
                    <p class="question-text"><span class="question-index" data-question="<?php echo $infosQuestion['idQuestion']; ?>">Question <?php echo $infosQuestion['indexQuestion']; ?> : </span><?php echo $infosQuestion['textQuestion']; ?></p>
                    <div class="quiz-answer">
                        <?php
                        foreach ($_GET['answers'][$infosQuestion['indexQuestion'] - 1] as $infosAnswers) {
                        ?>
                            <label class="label-quiz">
                                <p class="anwser-text"><?php echo $infosAnswers['textAnswer']; ?></p>
                                <input type="radio" name="<?php echo $infosQuestion['idQuestion']; ?>" data-answer="<?php echo $infosAnswers['idAnswer']; ?>">
                                <span class="checkmark"></span>
                            </label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="button-quiz-zone">
            <button id="button-previous" class="button-text">Retour</button>
            <button id="button-verify" class="button-text">Vérifier</button>
        </div>
    </div>
</div>