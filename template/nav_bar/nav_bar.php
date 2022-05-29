<?php
echo "<style>";
include 'nav_bar.css';
echo "</style>";
echo "<script>";
include 'nav_bar.js';
echo "</script>";

function add_menu($list = [], $link = [], $title="", $title_link = "", $message_link = "", $pre_link = ""){
  echo "<div class='--nav_bar-wrap'>";
  echo "<a class='--nav_bar-main-link' href='$title_link'>";
  echo "<h1 class='--nav_bar-title'>$title</h1>";
  echo "</a>";

  echo "<ul class='--nav_bar-box'>";
  foreach ($list as $key => $value) {
    echo "<li class='--nav_bar-li'><a class='--nav_bar-link' href='$pre_link$link[$key]'>$value</a></li>";
  }
  echo "</ul>";
  echo "<a class='--nav_bar-link-message' href='$message_link'><img class='--nav_bar-icon-message' src='https://cdn-icons-png.flaticon.com/512/6460/6460529.png' alt='ici'></img></a>";

  // fentre settings 
  echo "<a class='img_link' href='#demo'><img class='--nav_bar-wrap-profile-picture' src='".$_SESSION['profile_picture']."' alt='ici'></img></a>";
  echo "<div id='demo' class='modal'>";
  echo "<div class='modal_content'>";
  echo "<h1>".$_SESSION['pseudo']."</h1>";
  echo "<img class='--nav_bar-wrap-profile-picture' src='".$_SESSION['profile_picture']."' alt='ici'></img>";  echo "<a href='#' class='modal_close'>&times;</a>";
  echo "<br>";
  echo "<a class='--nav_bar-button' href='$pre_link"."content/setting/settings.php'>Gérer votre compte</a>";
  if ($_SESSION['type_user'] == "etudiant"){
    echo "<p class='nav_bar-info-text'>Ma moyenne : ".$_SESSION['moyenne']."</p><br>";
    echo "<p class='nav_bar-info-text'>Mes ECTS : ".$_SESSION['ECTS']."</p>";
  }
  echo "<a class='--nav_bar-button' href='$pre_link"."content/connexion/deconnexion.php'>Se déconnecter</a>";

  echo "</div>";
  echo "</div>";
  echo "</div>";
    // fin
}

function add_menu_from_csv($path_csv = "", $title = "", $pre_link = "", $title_link = ""){
  $list = [];
  $link = [];
  $title_link = $pre_link.$title_link;
  $message_link = $pre_link."content/conversation/conv_manager/conv_manager.php?state=conversation";

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

  add_menu($list, $link, $title, $title_link, $message_link, $pre_link);
}
//ajouter un margin au parent (de la taille de la nav bar)
 ?>
