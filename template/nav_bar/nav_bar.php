<?php
include 'nav_bar.css';

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
#chercher les infos du menu dans le csvcorrespondant a la page (etudiant / admin / administration)
#ajouter le menu a la page et lier le css du menu a la page
 ?>
