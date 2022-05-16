<?php
session_start();
include "../../../function/csv.php";

function create_info_text($info, $class = ""){
  echo("<div class='--conv-wrap-part-conv $class'>");
  echo("<p class='--conv-info-text'>");
  echo($info);
  echo("</p></div>");
}

function create_message($content, $self = true, $pseudo = "profile picture", $profile_picture = "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png", $content_type = "text"){
  $self_wrap_part_class = "";
  $self_message_class = "";
  if ($self){
    $self_wrap_part_class = "--conv-self-wrap-part-conv";
    $self_message_class = "--conv-self-message";
  }
  echo("<div class='--conv-wrap-part-conv $self_wrap_part_class'>");
  if ($self){
    add_3_point();
  }
  echo("<div class='--conv-wrap-message $self_message_class'>");
  if (! $self){
    echo("<img class='--conv-profile-picture' src='$profile_picture' alt='$pseudo'></img>");
    echo("<p class='--conv-message-pseudo'>$pseudo</p>");
  }
  if ($content_type == "text"){
    echo("<p class='--conv-message'>$content</p>");
  }elseif ($content_type == "img"){
    echo("<img class='--conv-message-img' src='$content' alt='error loading this image, try delete or modify the link'></img>");
  }
  echo('</div>');
  if (! $self){
    add_3_point();
  }
  echo('</div>');
}

function add_3_point(){
  echo('<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>');
}

function show_conv($conv_path, $csv_path_data_list){
  $content_conv = get_content_in_array($conv_path);
  array_shift($content_conv);
  $content_index = get_collum_by_name($conv_path, "content");
  $content_type_index = get_collum_by_name($conv_path, "content_type");
  $login_sender_index = get_collum_by_name($conv_path, "login_sender");
  if (count($content_conv) > 0){
    foreach ($content_conv as $key => $message) {
      if ($message[$content_type_index] == "text" or $message[$content_type_index] == "img"){
        foreach($csv_path_data_list as $k => $csv_path_data){
          if (($row = search_pseudo_line($csv_path_data, $message[$login_sender_index])) != []){
            $profile_picture_index = get_collum_by_name($csv_path_data, "profile picture");
            $profile_picture = $row[$profile_picture_index];
          }
        }
        create_message($message[$content_index], is_self_message($message[$login_sender_index]), $message[$login_sender_index], $profile_picture, $message[$content_type_index]);
      }elseif ($message[$content_type_index] == "join_info"){
        create_info_text($message[$content_index], "--conv-join-info");
      }
    }
  }else{
    create_info_text(get_random_row("../../../data/conversation/style/no_message.csv")[0], "no_message");
  }
}

function is_self_message($login_sender){
  if ($login_sender == $_SESSION["pseudo"]){
    return true;
  }
  return false;
}
 ?>
