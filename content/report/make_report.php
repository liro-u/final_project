<?php
include "../../function/csv.php";
session_start();

$motif = $_POST['motif'];
$content = $_POST['description'];
$_GET["data_list"] = json_encode(["../../data/admin/data.csv"]);

if (($row = get_random_row_exept_first("../../data/admin/data.csv")) != []){
  $index_pseudo = get_collum_by_name("../../data/admin/data.csv", "pseudo");
  $is_offline = false;
  if (! isset($_SESSION['pseudo'])){
    $is_offline = true;
    $_SESSION['pseudo'] = $row[$index_pseudo];
  }
  $user = $_SESSION['pseudo'];
  $_GET['pseudo'] = $row[$index_pseudo];
  $_GET['name_groupe'] = $motif;
  $_GET['type_conv'] = "report";
  $_GET['prelink'] = "../../";
  $data = json_decode(include "../conversation/conv_manager/create_conv.php");
  $_GET["conv"] = $data[1];
  $_GET["content_type"] = "report_info";
  $_GET["content"] = $content;
  $_GET['csv_path_data_list'] = "[]";
  include "../conversation/conversation/conv_php/send_message.php";
  if($is_offline){
    unset($_SESSION['pseudo']);
  }
  if ($data[0] == 1){
    header("Location: ../../index.php");
  }else{
    header("Location: report.php?error=failed_send");
  }
}
?>