<?php
session_start();
if ($_SESSION['type_user'] == "admin" or $_SESSION['type_user'] == "administration"){
  include "../../function/csv.php";
  $csv_path = $_GET["csv_path"];
  $line = $_GET["line"];
  remove_line($csv_path, $line);
  echo(1);
}else{
  echo(0);
}
 ?>