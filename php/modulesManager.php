<?php
include_once("../common.php");

if (isset($_POST["type"]) && isset($_POST['infos'])) {

  //Connection à la base de données et récupération des info du module
  $cnx = new Base(BASE, USERNAME, PASSWORD);

  $type = $_POST['type'];
  $infos = $_POST['infos'];

  switch ($type) {
    case 'addModule':
      $cnx->insert(
        "INSERT INTO module VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        array(null, 0, null, $infos[0]['value'], $infos[2]['value'], $infos[1]['value'], $infos[5], $infos[5], $user->getId(), $infos[3]['value'])
      );
      echo ($cnx->lastId());
      break;
    case 'addTextImageStep':
      $cnx->insert(
        "INSERT INTO stepTextImage VALUES (?, ?, ?, ?, ?, ?)",
        array(null, $infos[5], $infos[1]['value'], $infos[3]['value'], $infos[4][0], $infos[2]['value'])
      );
      $cnx->insert(
        "INSERT INTO step VALUES (?, ?, ?, ?, ?, ?, ?)",
        array(null, $infos[6], $infos[5], $cnx->lastId(), null, null, null)
      );
      
      break;
    case 'addTextVideoStep':
      $cnx->insert(
        "INSERT INTO stepTextVideo VALUES (?, ?, ?, ?, ?, ?)",
        array(null, $infos[5], $infos[1]['value'], $infos[2]['value'], $infos[4][0], $infos[3]['value'])
      );
      $cnx->insert(
        "INSERT INTO step VALUES (?, ?, ?, ?, ?, ?, ?)",
        array(null, $infos[6], $infos[5], null, $cnx->lastId(), null, null)
      );
      break;
    case 'addAudioImageStep':
      $cnx->insert(
        "INSERT INTO stepAudioImage VALUES (?, ?, ?, ?, ?, ?)",
        array(null, $infos[6], $infos[1]['value'], $infos[2]['value'], $infos[5][0], $infos[5][1], $infos[4]['value'], $infos[3]['value'])
      );
      $cnx->insert(
        "INSERT INTO step VALUES (?, ?, ?, ?, ?, ?, ?)",
        array(null, $infos[7], $infos[6], null, null, $cnx->lastId(), null)
      );
      break;
    case 'addQuizStep':
      /*
      $cnx->insert(
        "INSERT INTO stepAudioImage VALUES (?, ?, ?, ?, ?, ?)",
        array(null, 99, $infos[1]['value'], $infos[2]['value'], $infos[5][0], $infos[5][1], $infos[4]['value'], $infos[3]['value'])
      );
      */
      break;
    case 'deleteModule':
      $cnx->delete("DELETE FROM module WHERE id = ?", array($infos));
      break;
    case 'userQuiz':
      if (isset($_SESSION['user'])) {
        $cnx->insert("INSERT INTO userQuiz VALUES (?, ?, ?, ?)", array(null, $infos['quiz'], $user->getId(), $infos['note']));
      }
      break;
    case 'moduleCompleted':
      if (isset($_SESSION['user'])) {
        $cnx->update("UPDATE completed SET userNote = ? WHERE idModule = ? AND idUser = ?", array($infos['note'], $infos['module'], $user->getId()));
      }
      break;
    case 'resetUserQuiz':
      if (isset($_SESSION['user'])) {

        print_r("resetUserQuiz sur l'utilisateur : ".$user->getId());

        $quizzes = $cnx->query("SELECT uq.idQuiz FROM userQuiz uq
        INNER JOIN step s on s.idQuiz = uq.idQuiz
        INNER JOIN module m on s.idModule = m.id
        WHERE m.id = ?", array($user->getId()));

        foreach ($quizzes as $quiz) {
          $cnx->delete("DELETE FROM userQuiz WHERE idQuiz = ? AND idUser = ?", array($quiz['idQuiz'], $user->getId()));
          print_r($quiz['idQuiz'].$user->getId());
        }
      }
      break;
  }
}
