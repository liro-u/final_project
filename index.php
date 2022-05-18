<?php
session_start();
if (isset($_SESSION['type_user'])){
  header('location: test.php');
  exit;
}
header('location: content/connexion/connexion.php');
 ?>