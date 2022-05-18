<?php
session_start();
$line = $_GET["line"];
if (($_SESSION['type_user'] == "admin" or $_SESSION['type_user'] == "administration") and $line > 0){
  include "../../function/csv.php";
  $csv_path = $_GET["csv_path"];
  $tab = json_decode($_GET["tab"]);
  $data_tab = get_content_in_array($csv_path);
  foreach ($tab[0] as $key => $name) {
    $data_tab[$line][get_collum_by_name($csv_path, $name)] = $tab[1][$key];
  }
  replace_csv_by_array($csv_path, $data_tab);
  echo(1);
}else{
  echo(0);
}
 ?>
