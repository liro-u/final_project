<?php
$need_data = false;
if (! function_exists("get_collum_by_name")){
  include "../../../function/csv.php";
  session_start();
  $need_data = true;
}
$pre_link = $_GET['prelink'];
$pseudo = $_GET['pseudo'];
$name_groupe = $_GET['name_groupe'];
$user = $_SESSION["pseudo"];
$list_data_path = $_GET['data_list'];
$type_conv = $_GET['type_conv'];
if (str_replace(' ', '', $name_groupe) != ''){
  $name_groupe = str_replace(";", ",", $name_groupe);
  $conv_data_name = "$pre_link"."data/conversation/$type_conv"."_data/".$name_groupe.".csv";
  $i = 0;
  while (file_exists($conv_data_name)){
    $conv_data_name = "$pre_link"."data/conversation/$type_conv"."_data/".$name_groupe.$i.".csv";
    $i++;
  }
  if (($handle = fopen($conv_data_name, "a")) !== FALSE) {
    fputcsv($handle, ["login_sender","date","content_type","content","is_delete","delete_date"], ";");
    fputcsv($handle, ["",time(),"join_info",$user." a créer le groupe '".$name_groupe."'","",""], ";");
    fclose($handle);
  }

  $conv_info_name = "$pre_link"."data/conversation/$type_conv"."_info/".$name_groupe.".csv";
  $conv_name = "data/conversation/$type_conv"."_info/".$name_groupe.".csv";
  $i = 0;
  while (file_exists($conv_info_name)){
    $conv_info_name = "$pre_link"."data/conversation/$type_conv"."_info/".$name_groupe.$i.".csv";
    $conv_name = "data/conversation/$type_conv"."_info/".$name_groupe.$i.".csv";
    $i++;
  }
  if (($handle = fopen($conv_info_name, "a")) !== FALSE) {
    fputcsv($handle, ["name","adress","pseudo list"], ";");
    fputcsv($handle, [$name_groupe,basename($conv_data_name),""], ";");
    fclose($handle);
  }

  $index_pseudo_list = get_collum_by_name($conv_info_name, "pseudo list");
  $conv_data_content = get_content_in_array($conv_info_name);
  $conv_data_content[1][$index_pseudo_list] = $user;
  replace_csv_by_array($conv_info_name, $conv_data_content);
  if (($handle = fopen("$pre_link"."data/conversation/$type_conv"."_link/".$user.".csv", "a")) !== FALSE) {
    fputcsv($handle, [basename($conv_info_name)], ";");
    fclose($handle);
  }

  $_GET["conv"] = $conv_name;
  $_GET["pseudo"] = $pseudo;
  $_GET["data_list"] = $list_data_path;
  include "add_to_conv.php";
  if ($need_data){
    echo(json_encode([1, $conv_data_name, $conv_info_name]));
  }else{
    return(json_encode([1, $conv_data_name, $conv_info_name]));
  }
}

?>