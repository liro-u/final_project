<?php
session_start();
include "../../../../function/csv.php";

$pseudo = $_GET["pseudo"];
$data_list = json_decode($_GET['data_path']);
$user = $_SESSION["pseudo"];
foreach($data_list as $key => $data){
  if(($k_pseudo = search_pseudo_line_key($data, $user)) != []){
    break;
  }
}
if ($k_pseudo != []){
  $index_pseudo_bloque = get_collum_by_name($data, "pseudo bloquee");
  $data_content = get_content_in_array($data);
  $pseudo_list_bloque = explode(" ", $data_content[$k_pseudo][$index_pseudo_bloque]);
  if($pseudo_list_bloque[0] == ""){
    $pseudo_list_bloque = [];
  }
  if (! in_array($pseudo, $pseudo_list_bloque)){
    array_push($pseudo_list_bloque, $pseudo);
    $_SESSION['bloque'] = $pseudo_list_bloque;
    $data_content[$k_pseudo][$index_pseudo_bloque] = implode(" ", $pseudo_list_bloque);
    replace_csv_by_array($data, $data_content);
    echo"1";
  }
}
?>