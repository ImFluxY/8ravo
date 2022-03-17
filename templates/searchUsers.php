<?php
include_once("../common.php");

if (isset($_POST["search"])) {

  $search = $_POST["search"];

  //Connection à la base de données et récupération des info du module
  $cnx = new Base(BASE, USERNAME, PASSWORD);

  if ($search == "") {
    $result = $cnx->query("SELECT u.id, u.firstname, u.lastname, u.type, u.banned, u.avatar FROM users u ORDER BY firstname;");
  } else {
    $result = $cnx->query("SELECT u.id, u.firstname, u.lastname, u.type, u.banned, u.avatar FROM users u WHERE firstname LIKE ? OR lastname LIKE ? ORDER BY firstname", array("%$search%", "%$search%"));
  }

  if (empty($result)) {
    echo "<p>Aucun utilisateur trouvé</p>";
  } else {
    foreach ($result as $user) {
      $id = $user['id'];
      $firstname = $user['firstname'];
      $avatar = $user['avatar'];
      $lastname = $user['lastname'];
      $type = getTypeName($user['type']);
      $banned = $user['banned'] == 0 ? "<button data-user='$id' data-action='bann' class='btnBan'>Bannir</button>" : "<button data-user='$id' data-action='unbann' class='btnBan'>Débannir</button>";

      echo "<div class='userOptions'>
      <div class='userGestion'>
        <img class='avatarUser' alt='avatarUser' src='$avatar'>
        <div class='infoUser'>
          <p class='nomUser'>$firstname $lastname</p>
          <p class='roleUser'>$type</p>
        </div>
      </div>";
      switch ($user['type']) {
        case 0:
          echo $banned;
          echo "<button data-user='$id' data-action='defCreateur' class='btnRole'>Définir comme créateur</button>";
          break;
        case 1:
          echo $banned;
          echo "<button data-user='$id' data-action='rmveCreateur' class='btnRole'>Retirer le rôle créateur</button>";
          break;
        case 2:
          echo "<p class='noAction'>Aucune action possible</p>";
          break;
      }
      echo "</div>";
    }
    echo "<script src='./js/usersManager.js'></script>";
  }
} else {
  header("Location: ./index.php");
}
