<?php
echo "<style>";
include 'nav_bar.css';
echo "</style>";
echo "<script>";
include 'nav_bar.js';
echo "</script>";

function add_menu($list = [], $link = [], $title="", $message_link = "", $pre_link = ""){
  echo "<div class='--nav_bar-wrap'>";
  echo "<h1 class='--nav_bar-title'>$title</h1>";

  echo "<ul class='--nav_bar-box'>";
  foreach ($list as $key => $value) {
    echo "<li class='--nav_bar-li'><a class='--nav_bar-link' href='$pre_link$link[$key]'>$value</a></li>";
  }
  echo "</ul>";
  echo "<a class='--nav_bar-link-message' href='$message_link'><img class='--nav_bar-icon-message' src='https://cdn-icons-png.flaticon.com/512/6460/6460529.png' alt='ici'></img></a>";
  echo "<img class='--nav_bar-wrap-profile-picture' src='".$_SESSION['profile_picture']."' alt='ici'></img>";

  echo "</div>";
}

function add_menu_from_csv($path_csv = "", $title = "", $message_link = "", $pre_link = ""){
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

  add_menu($list, $link, $title, $message_link, $pre_link);
}
//ajouter un margin au parent (de la taille de la nav bar)
 ?>
