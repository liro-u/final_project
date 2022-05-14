<?php
include "../../../function/csv.php";
$csv_path_admin = "../../../data/admin/data.csv";
$csv_path_administration = "../../../data/administration/data.csv";
$csv_path_etudiant = "../../../data/etudiant/data.csv";
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
}elseif ($line = search_in_file_at_same_line($csv_path_etudiant, [$post_password, $post_login], ["password", "pseudo"])){
  $_SESSION['type_user'] = "etudiant";
  create_basic_session($csv_path_etudiant, $line);
}
if ($line){
  $_SESSION['pseudo'] = $post_login;
  $_SESSION['password'] = $post_password;
  header("location: ".$home_adress);
  exit();
}else{
  header("location: ".$connexion_adress."?error=wrong_mdp");
}

function create_basic_session($csv_path, $line){
  $_SESSION['profile_picture'] = $line[get_collum_by_name($csv_path, "profile picture")];
}
?>

