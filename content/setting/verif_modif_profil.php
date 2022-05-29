
<?php

include "../../content/admin/init_session.php";
session_start();
$csv_path_admin = "../../data/admin/data.csv";
$csv_path_administration = "../../data/administration/data.csv";
$csv_path_etudiant1 = "../../data/etudiant/choixEtudiantsParcours1.csv";
$csv_path_etudiant2 = "../../data/etudiant/choixEtudiantsParcours2.csv";
$csv_path_etudiant3 = "../../data/etudiant/choixEtudiantsParcours3.csv";
$list_file = [$csv_path_admin, $csv_path_administration, $csv_path_etudiant1, $csv_path_etudiant2, $csv_path_etudiant3];
$file = is_in_witch_file('pseudo', $_SESSION['pseudo'], $list_file);

$post_password2 = $_POST["password2"];
$post_password3 = $_POST["password3"];
$post_password4 = $_POST["password4"];

$post_adresse = $_POST["adresse"];

$post_photo = $_POST["photo"];

$post_jour = $_POST["jour"];
$post_mois = $_POST["mois"];
$post_annee = $_POST["annee"];
$post_anniversaire = $_POST["jour"]."/".$_POST["mois"]."/".$_POST["annee"];


//Modification mot de passe
if ($post_password2 == $_SESSION['password']){
  if ($post_password3 != "" and $post_password4 != ""){
    if ($post_password3 == $post_password4){
      //changer mot de passe dans le csv
      $ligne = search_pseudo_line_key($file, $_SESSION['pseudo']);
      $content = get_content_in_array($file);
      $index_password = get_collum_by_name($file, "password");
      $content[$ligne][$index_password] = $post_password3;
      replace_csv_by_array($file, $content);
      $_SESSION['password'] = $post_password3;
    }else{
      header("location:settings.php?error=wrong_mdp");
      exit;
    }
  }elseif($post_password3 != "" xor $post_password4 != ""){
    header("location:settings.php?error=wrong_mdp");
    exit;
  }
}

//------------------------------------------------------------------------------------------------------------------
//changement d'adresse

if ($post_adresse != "") {
  $ligne = search_pseudo_line_key($file, $_SESSION['pseudo']);
  $content = get_content_in_array($file);
  $index_adress = get_collum_by_name($file,"adress");
  $content[$ligne][$index_adress] = $post_adresse;
  replace_csv_by_array($file, $content);
  $_SESSION['adresse'] =  $post_adresse;
}
//------------------------------------------------------------------------------------------------------------------

/*
//changement pseudo
if ($post_pseudo != "") {
  if (!pseudo_exist($post_pseudo,$list_file,$file) ){
    $ligne = search_pseudo_line_key($file, $_SESSION['pseudo']);
    $content = get_content_in_array($file);
    $index_pseudo = get_collum_by_name($file, "pseudo");
    $content[$ligne][$index_pseudo] = $post_pseudo;
    replace_csv_by_array($file, $content);
    $_SESSION['pseudo'] = $post_pseudo;
  }else{
    header("location:settings.php?error=pseudo");
    exit;
  }
}*/

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//changement de photo
if (getimagesize($post_photo)) {
  $ligne = search_pseudo_line_key($file, $_SESSION['pseudo']);
  $content = get_content_in_array($file);
  $index_profile_picture = get_collum_by_name($file, "profile picture");
  $content[$ligne][$index_profile_picture] = $post_photo;
  replace_csv_by_array($file, $content);
  $_SESSION['profile_picture'] =  $post_photo;
}else{
  header("location:settings.php?error=wrong_link_pp");
  exit;
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//changement date de naissance

if ($post_jour != "" and $post_mois != "" and $post_annee != "") {
  $ligne = search_pseudo_line_key($file, $_SESSION['pseudo']);
  $content = get_content_in_array($file);
  $index_anniv = get_collum_by_name($file, "birth date");
  $content[$ligne][$index_anniv] = $post_photo;
  replace_csv_by_array($file, $content); 
  $_SESSION['anniversaire'] =  $post_anniversaire;
}
header("location: ../../index.php");
//need socket transport ssl
//need https wraper
?>
