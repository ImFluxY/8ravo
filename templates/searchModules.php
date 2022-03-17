<?php
include_once("../common.php");

if (isset($_POST["infos"]) && isset($_POST["type"])) {

  $category = $_POST["infos"]['category'];
  $search = $_POST["infos"]['search'];
  $type = $_POST["type"];

  //Connection à la base de données et récupération des info du module
  $cnx = new Base(BASE, USERNAME, PASSWORD);

  switch ($type) {
    case "display":

      if ($category == "all") {
        if($search == "")
        {
          $modulesInfos = $cnx->query("SELECT m.id, m.status, m.averageGrade, m.title, m.duration, m.mainPicture, c.categoryName
          FROM module m
          INNER JOIN moduleCategory c ON m.idCategory = c.idCategory
          WHERE m.status = ?", array("3"));
        }
        else
        {
          $modulesInfos = $cnx->query("SELECT m.id, m.status, m.averageGrade, m.title, m.duration, m.mainPicture, c.categoryName
          FROM module m
          INNER JOIN moduleCategory c ON m.idCategory = c.idCategory
          WHERE m.status = ? AND m.title LIKE ?", array("3", "%$search%"));
        }
      } else {
        if($search == "")
        {
          $modulesInfos = $cnx->query("SELECT m.id, m.status, m.averageGrade, m.title, m.duration, m.mainPicture, c.categoryName
          FROM module m
          INNER JOIN moduleCategory c ON m.idCategory = c.idCategory
          WHERE m.status = ? AND  m.idCategory = ?", array("3", $category));
        }
        else
        {
          $modulesInfos = $cnx->query("SELECT m.id, m.status, m.averageGrade, m.title, m.duration, m.mainPicture, c.categoryName
          FROM module m
          INNER JOIN moduleCategory c ON m.idCategory = c.idCategory
          WHERE m.status = ? AND  m.idCategory = ? AND m.title LIKE ?", array("3", $category, "%$search%"));
        }
      }

      foreach ($modulesInfos as $moduleInfos) {

        $id = $moduleInfos['id'];
        $mainPicture = $moduleInfos['mainPicture'];
        $averageGrade = $moduleInfos['averageGrade'];
        $title = $moduleInfos['title'];
        $categoryName = $moduleInfos['categoryName'];
        $duration = $moduleInfos['duration'];

        if (isset($_SESSION['user']))
          $urlModule = "./module.php?id=" . $id;
        else
          $urlModule = "./inscription.php";

        echo "<div class='swiper-slide'>
        <a href='$urlModule'>
          <div class='slider-box'>
            <div class='slider-box-img'>
              <img src='$mainPicture' alt=''>
            </div>
            <div class='slider-box-text'>
              <div class='container-note'>
                <span class='module-note'>$averageGrade / 5</span>
              </div>
              <div class='bottom-text'>
                <div class='module-name'>
                  <span>$title</span>
                  <p><span>$categoryName</span> · $duration min</p>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>";
      }
      break;

    case "delete":
      if ($infos == "") {
        $result = $cnx->query("SELECT * FROM module;");
      } else {
        $result = $cnx->query("SELECT * FROM module
        WHERE idCategory = ?;", array($infos));
      }

      if (empty($result)) {
        echo "<option value=''>Aucun module dans cette catégorie</option>";
      } else {
        echo "<option>Choisir le nom du module à supprimer</option>";
        foreach ($result as $module) {
          $id = $module['id'];
          $moduleName = $module['title'];
          echo "<option value='$id'>$moduleName</option>";
        }
      }
      break;
  }
}
