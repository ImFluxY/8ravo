<?php
include_once("../common.php");

if (isset($_POST["userId"]) && isset($_POST['action'])) {

  //Connection à la base de données et récupération des info du module
  $cnx = new Base(BASE, USERNAME, PASSWORD);
  switch ($_POST['action']) {
    case 'defCreateur':
      $cnx->update("UPDATE users SET type = '1' WHERE id = ?", array($_POST["userId"]));
      break;

//TEST  
    case 'refuserDemande':
      $date = date('Y-m-d');
      $cnx->update("UPDATE  creatorRequest c SET c.state = '2', c.dateRequest = ? WHERE c.idUser= ?", array($date ,$_POST["userId"]));
      break;
      
      case 'accepterDemande':
        $date = date('Y-m-d');
        $cnx->update("UPDATE  creatorRequest c SET c.state = '1', c.dateRequest = ? WHERE c.idUser= ?", array($date ,$_POST["userId"]));
        $cnx->update("UPDATE  users u SET u.type = '1' WHERE u.id= ?", array($_POST["userId"]));
        break;

        case 'bannirUSer':
          $date = date('Y-m-d');
          $cnx->update("UPDATE  users u SET u.banned = '1' WHERE u.id= ?", array($_POST["userId"]));
          $cnx->update("UPDATE  creatorRequest c SET c.state = '2', c.dateRequest = ? WHERE c.idUser= ?", array($date ,$_POST["userId"]));
          break;

    case 'rmveCreateur':
      $cnx->update("UPDATE users SET type = '0' WHERE id = ?", array($_POST["userId"]));
      
      break;
    case 'bann':
      $cnx->update("UPDATE users SET banned = '1' WHERE id = ?", array($_POST["userId"]));
      print_r("user ban");
      break;
    case 'unbann':
      $cnx->update("UPDATE users SET banned = '0' WHERE id = ?", array($_POST["userId"]));
      break;
  }
}
