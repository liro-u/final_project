<?php
include "../../../function/csv.php";
session_start();
$pseudo = $_GET['pseudo'];
$conv = $_GET['conv'];
$data_path_list = json_decode($_GET['data_list']);
$user = $_SESSION["pseudo"];

$index_pseudo_list = get_collum_by_name("../../../".$conv, "pseudo list");
$conv_data_content = get_content_in_array("../../../".$conv);
$list_pseudo_in_conv = explode(" ", $conv_data_content[1][$index_pseudo_list]);
if (in_array($user, $list_pseudo_in_conv)){
  if (exist_in_collum_name("pseudo", $pseudo, $data_path_list)){
    if (! in_array($pseudo, $list_pseudo_in_conv)){
      array_push($list_pseudo_in_conv, $pseudo);
      $conv_data_content[1][$index_pseudo_list] = implode(" ", $list_pseudo_in_conv);
      replace_csv_by_array("../../../".$conv, $conv_data_content);
      if (($handle = fopen("../../../data/conversation/conv_link/".$pseudo.".csv", "a")) !== FALSE) {
        fputcsv($handle, [basename($conv)], ";");
      }
    }
  }
}
?>