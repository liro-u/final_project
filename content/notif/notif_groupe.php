<?php
include "../../function/csv.php";
session_start();
$path = $_GET['csv_path'];
$content = get_content_in_array($path);
array_shift($content);
$index_final_option = get_collum_by_name($path, "attributed option");
$index_pseudo = get_collum_by_name($path, "pseudo");
$title = "attribution d'option";
$img = "https://cdn-icons-png.flaticon.com/512/1004/1004017.png";
foreach ($content as $k => $row){
  $message = "vous avez été associé a l'option ".$row[$index_final_option];
  if (! file_exists("../../data/conversation/notif_link/".$row[$index_pseudo].".csv")){
    if (($handle = fopen("../../data/conversation/notif_link/".$row[$index_pseudo].".csv", "a")) !== FALSE) {
      fputcsv($handle, ["name","content","img","link","date"], ";");
      fclose($handle);
    }
  }
  if (($handle = fopen("../../data/conversation/notif_link/".$row[$index_pseudo].".csv", "a")) !== FALSE) {
    fputcsv($handle, [$title, $message, $img, "", time()], ";");
    fclose($handle);
  }
}
echo"1";
?>