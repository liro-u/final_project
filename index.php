<?php
session_start();
if (isset($_SESSION['type_user'])){
  header("Location: test.php");
  exit;
}
header('Location: content/connexion/connexion.php?error=connexion_failed');
 ?>
