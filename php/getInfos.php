<?php
/* Retourner un objet JSON cotenant les informations d'une étape du module */
require_once('../common.php');

if (isset($_POST['type'])) {

  //Connexion à la bdd
  $cnx = new Base(BASE, USERNAME, PASSWORD);

  $type = $_POST['type'];

  switch ($type) {
    case 'getStep':

      if (isset($_SESSION['user'])) {
        $completed = $cnx->query('SELECT userCompleted FROM completed WHERE idModule = ? AND idUser = ?', array($_POST['module'], $user->getId()));
        if ($completed == null) {
          $cnx->insert('INSERT INTO completed (idModule, idUser, userCompleted) VALUES (?, ?, ?)', array($_POST['module'], $user->getId(), 0));
          echo json_encode(array("userCompleted" => 0));
        } else {
          echo json_encode($completed[0]);
        }
      } else {
        echo json_encode(array("userCompleted" => 0));
      }

      break;
    case 'getCorrectAnswers':

      if (isset($_POST['questions'])) {
        $correctAnswers = array();
        foreach ($_POST['questions'] as $question) {
          $correctAnswer = $cnx->query('SELECT idCorrectAnswer FROM quizQuestion WHERE idQuestion = ?', array($question));
          array_push($correctAnswers, $correctAnswer[0]['idCorrectAnswer']);
        }
        echo json_encode($correctAnswers);
      }

      break;
    case 'getUserQuiz':

      if (isset($_SESSION['user']) && isset($_POST['quiz'])) {
        $userQuiz = $cnx->query('SELECT note FROM userQuiz WHERE idQuiz = ? AND idUser = ?', array($_POST['quiz'], $user->getId()));

        if ($userQuiz != null)
          echo json_encode($userQuiz[0]);
        else
          echo json_encode(null);
      }

      break;

    case 'getUserQuizzesNote':

      if (isset($_SESSION['user']) && isset($_POST['module'])) {
        $correctAnswers = $cnx->query("SELECT SUM(uq.note) AS note FROM userQuiz uq
        WHERE uq.idUser = ?", array($user->getId()));

        $questionCount =  $cnx->query("SELECT COUNT(qq.idQuestion) AS questions FROM quizQuestion qq
        INNER JOIN stepQuiz sq ON sq.idQuiz = qq.idQuiz
        WHERE sq.idModule = ?", array($_POST['module']));

        $result = array($correctAnswers[0], $questionCount[0]);

        echo json_encode($result);
      }

      break;
  }
}
