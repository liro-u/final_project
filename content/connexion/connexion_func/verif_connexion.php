<?php
include "../../../function/csv.php";
$csv_path_admin = "../../../data/admin/data.csv";
$csv_path_administration = "../../../data/administration/data.csv";
$csv_path_etudiant1 = "../../../data/etudiant/choixEtudiantsParcours1.csv";
$csv_path_etudiant2 = "../../../data/etudiant/choixEtudiantsParcours2.csv";
$csv_path_etudiant3 = "../../../data/etudiant/choixEtudiantsParcours3.csv";
$home_adress = "../../../test.php";
$connexion_adress = "../connexion.php";

$post_password = $_POST["password"];
$post_login = $_POST["login"];

session_start();
$line = NULL;
if ($line = search_in_file_at_same_line($csv_path_admin, [$post_password, $post_login], ["password", "pseudo"])){
  $_SESSION['type_user'] = "admin";
  create_basic_session($csv_path_admin, $line);
}elseif ($line = search_in_file_at_same_line($csv_path_administration, [$post_password, $post_login], ["password", "pseudo"])){
  $_SESSION['type_user'] = "administration";
  create_basic_session($csv_path_administration, $line);
}else{
  foreach ([$csv_path_etudiant1, $csv_path_etudiant2, $csv_path_etudiant3] as $key => $csv_path_etudiant) {
    if ($temp_line = search_in_file_at_same_line($csv_path_etudiant, [$post_password, $post_login], ["password", "pseudo"])){
      $line = $temp_line;
      $_SESSION['type_user'] = "etudiant";
      $_SESSION['moyenne'] = $line[get_collum_by_name($csv_path_etudiant, "Moyenne")];
      $_SESSION['ECTS'] = $line[get_collum_by_name($csv_path_etudiant, "ECTS acquis")];
      create_basic_session($csv_path_etudiant, $line);
    }
  }
}
if ($line){
  $_SESSION['pseudo'] = $post_login;
  $_SESSION['password'] = $post_password;
  header("Location: ".$home_adress);
  exit();
}else{
  header("Location: ".$connexion_adress."?error=wrong_mdp");
}

function create_basic_session($csv_path, $line){
  $_SESSION['profile_picture'] = $line[get_collum_by_name($csv_path, "profile picture")];
  $_SESSION['bloque'] = explode(" ", $line[get_collum_by_name($csv_path, "pseudo bloquee")]);
}
?>
