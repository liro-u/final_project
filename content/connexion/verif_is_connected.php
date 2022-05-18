<?php
session_start();
if (! isset($_SESSION['type_user'])){
  header("location: ../../../index.php");
}
 ?>
