<?php
echo "<style>";
include 'nav_bar.css';
echo "</style>";
echo "<script>";
include 'nav_bar.js';
echo "</script>";

function add_menu($list = [], $link = [], $title=""){
  echo "<div class='--nav_bar-wrap'>";
  echo "<h1 class='--nav_bar-title'>$title</h1>";

  echo "<ul class='--nav_bar-box'>";
  foreach ($list as $key => $value) {
    echo "<li class='--nav_bar-li'><a class='--nav_bar-link' href='$link[$key]'>$value</a></li>";
  }
  echo "</ul>";

  echo "</div>";
}

function add_menu_from_csv($path_csv = "", $title = ""){
  $list = [];
  $link = [];

  if (($handle = fopen($path_csv, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
      $num = count($data);
      if (isset($data[0])){
        array_push($list, $data[0]);
        if (isset($data[1])){
          array_push($link, $data[1]);
        }else{
          array_push($link, "");
        }
      }
    }
    fclose($handle);

  }

  add_menu($list, $link, $title);
}

#chercher les infos du menu dans le csvcorrespondant a la page (etudiant / admin / administration)
#ajouter le menu a la page et lier le css du menu a la page
 ?>
