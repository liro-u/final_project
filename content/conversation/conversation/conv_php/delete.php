<?php
session_start();
include "../../../../function/csv.php";

$nb_msg = $_GET['nb_msg'];
$conv_path = $_GET['conv_path'];
$user = $_SESSION['pseudo'];

$content = get_content_in_array($conv_path);
$index_delete_date = get_collum_by_name($conv_path, "delete_date");
$index_is_delete = get_collum_by_name($conv_path, "is_delete");
$index_sender = get_collum_by_name($conv_path, "login_sender");
if ($user == $content[$nb_msg][$index_sender]){
  $content[$nb_msg][$index_is_delete] = true;
  $content[$nb_msg][$index_delete_date] = time();
  replace_csv_by_array($conv_path, $content);
  echo"1";
}
?>