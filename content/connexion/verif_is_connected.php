<?php
function verif_can_access($list = ["administration", "admin", "etudiant"], $path = ""){
  if (! isset($_SESSION['type_user'])){
    header("Location: ".$path."index.php");
    exit;
  }else{
    $verif = false;
    foreach ($list as $key => $value) {
      if ($value == $_SESSION['type_user']){
        $verif = true;
        break;
      }
    }
    if (! $verif){
      header("Location: ".$path."index.php");
      exit;
    }
  }
}
 ?>
