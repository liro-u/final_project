<?php
session_start();
$conversation_path = $_GET["conv"];
$content_type = $_GET["content_type"];
$content = $_GET["content"];
$date = getdate()[0];
$user = $_SESSION["pseudo"];
$csv_path_data_list = json_decode($_GET["csv_path_data_list"]);
include "../../../../function/csv.php";
$new_line = [];
$new_line = array_fill(0, getSizeFirstLine($conversation_path), "");
$new_line[get_collum_by_name($conversation_path, "content_type")] = $content_type;
$new_line[get_collum_by_name($conversation_path, "content")] = $content;
$new_line[get_collum_by_name($conversation_path, "date")] = $date;
$new_line[get_collum_by_name($conversation_path, "login_sender")] = $user;
add_row_from_array($conversation_path, $new_line);
foreach($csv_path_data_list as $k => $csv_path_data){
  if (($row = search_pseudo_line($csv_path_data, $user)) != []){
    $profile_picture_index = get_collum_by_name($csv_path_data, "profile picture");
    $profile_picture = $row[$profile_picture_index];
  }
}
$data = [$user, $profile_picture];
echo json_encode($data);
 ?>
