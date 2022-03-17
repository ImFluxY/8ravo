<?php
error_reporting(-1);
ini_set('display_errors', 'On');

/* Retourner un objet JSON cotenant les informations d'une étape du module */
require_once('../common.php');

if (isset($_POST)) {

    //Récupération de l'id du module
    $module = $_POST['module'];

    //Récupération de l'étape à charger
    $step = $_POST['step'];

    //Connection à la base de données et récupération des info du module
    $cnx = new Base(BASE, USERNAME, PASSWORD);

    //Récupération des infos de l'étape depuis la base de données

    if ($step > 0 && $step < 9) {

        $lignes = $cnx->query('SELECT * FROM step WHERE idModule = ? AND indexStep = ?', array($module, $step));

        if (!is_null($lignes[0]['idTextImage'])) {
            $infos = $cnx->query('SELECT * FROM stepTextImage WHERE idModule = ? AND idTextImage = ?', array($module, $lignes[0]['idTextImage']));
            echo json_encode($infos[0]);
        }

        if (!is_null($lignes[0]['idTextVideo'])) {
            $infos = $cnx->query('SELECT * FROM stepTextVideo WHERE idModule = ? AND idTextVideo = ?', array($module, $lignes[0]['idTextVideo']));
            echo json_encode($infos[0]);
        }

        if (!is_null($lignes[0]['idAudioImage'])) {
            $infos = $cnx->query('SELECT * FROM stepAudioImage WHERE idModule = ? AND idAudioImage = ?', array($module, $lignes[0]['idAudioImage']));
            echo json_encode($infos[0]);
        }

        if (!is_null($lignes[0]['idQuiz'])) {
            $infosQuiz = $cnx->query('SELECT * FROM stepQuiz WHERE idModule = ? AND idQuiz = ?', array($module, $lignes[0]['idQuiz']));
            $questions = $cnx->query('SELECT * FROM quizQuestion WHERE idQuiz = ?', array($lignes[0]['idQuiz']));

            $answers = array();
            foreach ($questions as $question) {
                $answer = $cnx->query('SELECT * FROM quizAnswer WHERE idQuestion = ?', array($question['idQuestion']));
                array_push($answers, $answer);
            }

            $infos = array("infos" => $infosQuiz[0], "questions" => $questions, "answers" => $answers);
            echo json_encode($infos);
        }
    } else {
        $infosModule = $cnx->query('SELECT * FROM module WHERE id = ?', array($module));

        //Envoie des infos
        echo json_encode($infosModule[0]);
    }

    //Si l'utilisateur est déjà renseigné dans completed, mettre à jour, sinon insérer
    if (isset($_SESSION['user'])) {
        $completed = $cnx->query('SELECT id FROM completed WHERE idModule = ? AND idUser = ?', array($module, $user->getId()));

        if($completed[0] != null){
            $cnx->update('UPDATE completed SET userCompleted = ? WHERE id = ?', array($step, $completed[0]['id']));
        }
        else{
            $cnx->insert('INSERT INTO completed (idModule, idUser, userCompleted) VALUES (?, ?, ?)', array($module, $user->getId(), $step));
        }
    }
}
