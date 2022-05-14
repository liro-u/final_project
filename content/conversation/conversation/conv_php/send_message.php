<?php
$conversation_path = $_GET["conv"];
$content_type = $_GET["content_type"];
$content = $_GET["content"];
$date = $_GET["date"];
include "../../../../function/csv.php";
$new_line = [];
$new_line = array_fill(0, getSizeFirstLine($conversation_path), "");
$new_line[get_collum_by_name($conversation_path, "content_type")] = $content_type;
$new_line[get_collum_by_name($conversation_path, "content")] = $content;
$new_line[get_collum_by_name($conversation_path, "date")] = $date;
add_row_from_array($conversation_path, $new_line);
 ?>
