<?php
session_start();
$line = $_GET["line"];
if (($_SESSION['type_user'] == "admin" or $_SESSION['type_user'] == "administration") and $line > 0){
  include "../../function/csv.php";
  $csv_path = $_GET["csv_path"];
  remove_line($csv_path, $line);
  echo(1);
}else{
  echo(0);
}
 ?>