<?php
include "../../../../function/csv.php";
session_start();
$nb_msg = $_GET["nb_msg"];
$conv_path = $_GET["conv_path"];
$motif = $_GET["motif"];
$date = date('j F Y', time())." a ".date('G:i', time());
$user = $_SESSION['pseudo'];
$index_content = get_collum_by_name($conv_path, "content");
$message = get_content_in_array($conv_path)[$nb_msg][$index_content];
$content = "le message ".'"'.$message.'"'." a ete signalé par $user le $date<br>nb_msg = $nb_msg<br>conv_path = $conv_path<br>motif = $motif";
if (($row = get_random_row_exept_first("../../../../data/admin/data.csv")) != []){
  $index_pseudo = get_collum_by_name("../../../../data/admin/data.csv", "pseudo");
  $_GET['pseudo'] = $row[$index_pseudo];
  $_GET['name_groupe'] = $motif;
  $_GET['type_conv'] = "report";
  $_GET['prelink'] = "../../../../";
  $data = json_decode(include "../../conv_manager/create_conv.php");
  $_GET["conv"] = $data[1];
  $_GET["content_type"] = "report_info";
  $_GET["content"] = $content;
  $_GET['csv_path_data_list'] = "[]";
  include "send_message.php";
  echo($data[0]);
}
?>