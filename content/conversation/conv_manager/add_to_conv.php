<?php
$is_called_first = false;
if (! function_exists("get_collum_by_name")){
  include "../../../function/csv.php";
  session_start();
  $is_called_first = true;
}
$pseudo = $_GET['pseudo'];
$conv = $_GET['conv'];
$data_path_list = json_decode($_GET['data_list']);
$user = $_SESSION["pseudo"];
$type_conv = $_GET["type_conv"];
$prelink = $_GET['prelink'];

$index_pseudo_list = get_collum_by_name($prelink.$conv, "pseudo list");
$index_conv = get_collum_by_name($prelink.$conv, "adress");
$conv_data_content = get_content_in_array($prelink.$conv);
$list_pseudo_in_conv = explode(" ", $conv_data_content[1][$index_pseudo_list]);
if (in_array($user, $list_pseudo_in_conv)){
  if (exist_in_collum_name("pseudo", $pseudo, $data_path_list)){
    if (! in_array($pseudo, $list_pseudo_in_conv)){
      array_push($list_pseudo_in_conv, $pseudo);
      $conv_data_content[1][$index_pseudo_list] = implode(" ", $list_pseudo_in_conv);
      replace_csv_by_array($prelink.$conv, $conv_data_content);
      if (($handle = fopen($prelink."data/conversation/$type_conv"."_link/".$pseudo.".csv", "a")) !== FALSE) {
        fputcsv($handle, [basename($conv)], ";");
        fclose($handle);
      }
      if (($handle = fopen($prelink."data/conversation/$type_conv"."_data/".$conv_data_content[1][$index_conv], "a"))){
        fputcsv($handle, ["",time(),"join_info",$user." a ajouté ".$pseudo." au groupe","",""], ";");
        fclose($handle);
      }
      if ($is_called_first){
        echo("1");
      }
    }
  }
}

?>