<?php
include "../../../function/csv.php";


function load_profile_conv($pre_link="../../../"){
  $preview_exist = false;
  if ($_GET['state'] == "conversation"){
    $target_folder = 'conv_link';
  }elseif ($_GET['state'] == "notification"){
    $target_folder = 'notif_link';
  }elseif ($_GET['state'] == 'admin'){
    $target_folder = 'report_link';
  }
  if (file_exists($total_path = $pre_link."data/conversation/".$target_folder."/".$_SESSION['pseudo'].".csv")){
    $content = get_content_in_array($total_path);
    if ($target_folder == 'conv_link' or $target_folder == 'report_link'){
      foreach ($content as $key => $row) {
        $preview_exist = true;
        load_conv("data/conversation/conv_info/".$row[0], $pre_link);
      }
    }elseif ($target_folder == 'notif_link'){
      $index_name = get_collum_by_name($total_path, "name");
      $index_content = get_collum_by_name($total_path , "content");
      $index_img = get_collum_by_name($total_path, "img");
      $index_link = get_collum_by_name($total_path, "link");
      $index_date = get_collum_by_name($total_path, "date");
      array_shift($content);
      foreach ($content as $key => $row) {
        $preview_exist = true;
        create_preview($row[$index_name], $row[$index_content], $row[$index_link], $row[$index_img], $row[$index_date], 'notif');
      }
    }
  }
  if (! $preview_exist){
    if ($target_folder == 'conv_link'){
      create_preview("", get_random_row("../../../data/conversation/style/no_conv.csv")[0], "", "", "", "info");
    }elseif ($target_folder == 'notif_link'){
      create_preview("", "pas de notification pour le moment", "", "", "", "info");
    }elseif ($target_folder == 'report_link'){
      create_preview("", "pas de requette pour le moment", "", "", "", "info");
    }
  }
}

function load_conv($conv_path, $pre_link = "../../../"){
  $csv_path = $pre_link.$conv_path;
  $data_list = [$pre_link."data/etudiant/choixEtudiantsParcours1.csv", $pre_link."data/etudiant/choixEtudiantsParcours2.csv", $pre_link."data/etudiant/choixEtudiantsParcours3.csv", $pre_link."data/admin/data.csv", $pre_link."data/administration/data.csv"];

  $content = get_content_in_array($csv_path);
  $index_name = get_collum_by_name($csv_path, "name");
  $index_path_conv = get_collum_by_name($csv_path, "adress");
  $index_list_pseudo = get_collum_by_name($csv_path, "pseudo list");
  $conv_name = $content[1][$index_name];
  $conv_adress = $pre_link."data/conversation/conv_data/".$content[1][$index_path_conv];
  $pseudo_list = explode(" ", $content[1][$index_list_pseudo]);
  $repr_pseudo = $pseudo_list[0];
  if (count($pseudo_list) > 1){
    foreach($pseudo_list as $k => $pseudo){
      if ($pseudo != $_SESSION['pseudo']){
        $repr_pseudo = $pseudo;
        break;
      }
    }
  }
  $data_profile = $_SESSION['pseudo'];
  foreach($data_list as $key => $data){
    $row = search_pseudo_line($data, $repr_pseudo);
    if ($row != []){
      $data_profile = $data;
      break;
    }
  }
  $index_profile_picture = get_collum_by_name($data_profile, "profile picture");
  $profile_picture = $row[$index_profile_picture];
  $conv_content = get_content_in_array($conv_adress);
  $index_type_content = get_collum_by_name($conv_adress, "content_type");
  $index_content = get_collum_by_name($conv_adress, "content");
  $index_date = get_collum_by_name($conv_adress, "date");
  $last_message = "vous n'avez pas de message dans cette conversation 😥";
  $date = "";
  for($i = -1; $i > -count($conv_content); $i--){
    $line_index = count($conv_content) + $i;
    if ($conv_content[$line_index][$index_type_content] == "text"){
      $last_message = $conv_content[$line_index][$index_content];
      $date = $conv_content[$line_index][$index_date];
      break;
    }
    if ($conv_content[$line_index][$index_type_content] == "img"){
      $last_message = "vous avez reçus une photo 📷";
      $date = $conv_content[$line_index][$index_date];
      break;
    }
  }

  $conv_temp_address = $pre_link."content/conversation/conversation/conv_template.php?name=".$conv_name."&conv_path=../../../data/conversation/conv_data/".$content[1][$index_path_conv]."&conv_info=../../../".$conv_path;
  create_preview($conv_name, $last_message, $conv_temp_address, $profile_picture, $date, "message", $conv_path);
}

function create_preview($title = '', $content = '', $link = '', $img = '', $date = '', $type = "message", $conv_path = ""){
  echo ('<tr class="one_box">');
  if ($img != ""){
    echo('<td>');
    echo("<img class='img_friend' src='$img' alt='' />");
    echo("</td>");
  }
  echo("<td class='text_box'>");
  if ($link != ''){
    echo("<a class='link' href='$link'>");
  }
  echo("<div class='link_wrap'>");
  if ($title != ""){
    echo("<span class='name'>$title</span>");
  }
  if ($content != ""){
    echo("<p class='message_text'>$content</p>");
  }
  echo("</div>");
  if ($link != ''){
    echo("</a>");
  }
  echo("</td>");
  if ($type == 'message'){
    echo("<td class='icon'>");
    echo("<i class='fa plus_per' onclick='ShowaddtoGroupe(".'"'.$conv_path.'"'.")'>&#xf067;</i>");
    echo("</td>");
  }
  if ($date != ""){
    $pretty_date = get_pretty_time($date);
    echo("<td class='time'>$pretty_date</td>");
  }
  echo("</tr>");
}
 ?>
