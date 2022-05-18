<?php
include "../../function/csv.php";

function create_random_password($longueur = 6){
 $caracteres = '@!-_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $longueurMax = strlen($caracteres);
 $chaineAleatoire = '';
 for ($i = 0; $i < $longueur; $i++)
 {
 $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
 }
 return $chaineAleatoire;
}

function is_just_space($word){
  if (str_replace(' ', '', $word) == ''){
    return true;
  }
  return false;
}

function password_is_ok($password){
  if (is_just_space($password)){
    return false;
  }
  return true;
}

function pseudo_is_ok($pseudo){
  if (is_just_space($pseudo)){
    return false;
  }
  return true;
}

function pseudo_exist($pseudo, $csv_path_list, $csv_path, $tab = []){
  if (exist_in_collum_name("pseudo", $pseudo, $csv_path_list)){
    return true;
  }elseif (exist_in_collum_name_array("pseudo",$pseudo, $csv_path, $tab)){
    return true;
  }
  return false;
}

function create_pseudo($nom, $prenom, $csv_path_list, $csv_path, $tab = []){
  $pseudo = $nom . "." . $prenom;
  $c = 0;
  while (pseudo_exist($pseudo, $csv_path_list, $csv_path, $tab)){
    $pseudo = $nom . "." . $prenom . $c;
    $c++;
  };
  return $pseudo;
}

function setup_first_line_param($csv_path, $param, $tab, $bonus = 0){
  if(get_collum_by_name($csv_path, $param) == -1){
    $tab[0][] = $param;
    $index = getSizeFirstLine($csv_path) + $bonus;
  }else{
    $index = get_collum_by_name($csv_path, $param);
  }
  return [$tab, $index];
}

function init_session($csv_path, $csv_path_list, $profile_picture_path){
  $csv_path_list[] = $csv_path;
  $content_csv = get_content_in_array($csv_path);

  //setup first_line and index constant
  $index_prenom = get_collum_by_name($csv_path, "prenom");
  $index_nom = get_collum_by_name($csv_path, "nom");
  $res = setup_first_line_param($csv_path, "password", $content_csv);
  $content_csv = $res[0];
  $index_password = $res[1];
  $res = setup_first_line_param($csv_path, "pseudo", $content_csv, 1);
  $content_csv = $res[0];
  $index_pseudo = $res[1];
  $res = setup_first_line_param($csv_path, "profile picture", $content_csv, 2);
  $content_csv = $res[0];
  $index_profile_picture = $res[1];
  //this will not be automatically filled
  $res = setup_first_line_param($csv_path, "birth date", $content_csv, 3);
  $content_csv = $res[0];
  $res = setup_first_line_param($csv_path, "adress", $content_csv, 4);
  $content_csv = $res[0];

  //fill tab with nothing to match them size
  $content_csv = match_tab_row_size($content_csv);

  //update first_line and same size in file
  replace_csv_by_array($csv_path, $content_csv);

  //fill tab with correct missing value
  $copy_content_csv = $content_csv;
  array_shift($copy_content_csv);
  foreach($copy_content_csv as $key => $row){
    if (! password_is_ok($row[$index_password])){
      $content_csv[$key + 1][$index_password] = create_random_password();
    }
    if ((! pseudo_is_ok($row[$index_pseudo])) and $index_prenom != -1 and $index_nom != -1){
      $content_csv[$key + 1][$index_pseudo] = create_pseudo($row[$index_prenom], $row[$index_nom], $csv_path_list, $csv_path, $content_csv);
    }
    if (is_just_space($row[$index_profile_picture])){
      $content_csv[$key + 1][$index_profile_picture] = get_random_row($profile_picture_path)[0];
    }
  }

  //replace last csv file by new tab
  replace_csv_by_array($csv_path, $content_csv);
}
?>
