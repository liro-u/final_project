<?php
session_start();
include "../../../function/csv.php";
echo("<meta name='csv_path' content='../".$_GET['conv_path']."'>");
$content = get_content_in_array($_GET['conv_info']);
$index_list_pseudo = get_collum_by_name($_GET['conv_info'], "pseudo list");
$pseudo_list = explode(" ", $content[1][$index_list_pseudo]);
if (! in_array($_SESSION['pseudo'], $pseudo_list)){
  header('Location: ../../../../index.php');
  exit;
}

function create_info_text($info, $class = ""){
  echo("<div class='--conv-wrap-part-conv $class'>");
  echo("<p class='--conv-info-text'>");
  echo($info);
  echo("</p></div>");
}

function create_message($nb_msg, $content, $self = true, $pseudo = "profile picture", $profile_picture = "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png", $date = "",$content_type = "text"){
  $self_wrap_part_class = "";
  $self_message_class = "";
  if ($self){
    $self_wrap_part_class = "--conv-self-wrap-part-conv";
    $self_message_class = "--conv-self-message";
  }
  echo("<div class='--conv-wrap-part-conv $self_wrap_part_class' nb_msg='$nb_msg'>");
  if ($self){
    echo("<p class='--conv-date'>$date</p>");
    add_3_point($self);
  }
  echo("<div class='--conv-wrap-message $self_message_class'>");
  if (! $self ){
    if ($profile_picture != ""){
      echo("<img class='--conv-profile-picture' src='$profile_picture' alt='$pseudo'></img>");
    }
    echo("<p class='--conv-message-pseudo'>$pseudo</p>");
  }
  if ($content_type == "text"){
    echo("<p class='--conv-message'>$content</p>");
  }elseif ($content_type == "img"){
    echo("<img class='--conv-message-img' src='$content' alt='error loading this image, try delete or modify the link'></img>");
  }
  echo('</div>');
  if (! $self){
    add_3_point($self);
    echo("<p class='--conv-date'>$date</p>");
  }
  echo('</div>');
}

function add_3_point($self){
  echo("<div class='--conv-popup' onclick='show_popup_button(this)'>");
  echo('<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>');
  echo("<div class='--conv-popuptext");
  if ($self){
    echo(" --conv-self-popuptext");
  }
  echo("'><div class='--conv-popup'>");
  if (! $self){
    echo("<p class='--conv-button-popup-text' onclick='bloque(this)'>bloquer</p>");
    echo("<p class='--conv-button-popup-text' onclick='signaler(this)'>signaler message</p>");
  }else{
    echo("<p class='--conv-button-popup-text' onclick='delete_msg(this)'>supprimer</p>");
    echo("<p class='--conv-button-popup-text'>modifier</p>");
  }
  echo("</div></div>");
  echo("</div>");
}

function show_conv($conv_path, $csv_path_data_list){
  $content_conv = get_content_in_array($conv_path);
  array_shift($content_conv);
  $index_is_delete = get_collum_by_name($conv_path, "is_delete");
  $content_index = get_collum_by_name($conv_path, "content");
  $content_type_index = get_collum_by_name($conv_path, "content_type");
  $login_sender_index = get_collum_by_name($conv_path, "login_sender");
  $date_index = get_collum_by_name($conv_path, "date");
  $is_empty = true;
  $nb_msg = 1;
  $last_message = date("j-m-Y", 0);
  if (count($content_conv) > 0){
    foreach ($content_conv as $key => $message) {
      if (date("j-m-Y", $message[$date_index]) != $last_message){
        create_info_text(get_pretty_time($message[$date_index], "day"), "--conv-date-info");
        $last_message = date("j-m-Y", $message[$date_index]);
      }
      if ($message[$content_type_index] == "text" or $message[$content_type_index] == "img" or ($message[$content_type_index] == "report_info" and $_SESSION['type_user'] == 'admin')){
        $date = date('G:i', $message[$date_index]);
        $sender_pseudo = $message[$login_sender_index];
        $content_message = $message[$content_index];
        $type = $message[$content_type_index];
        if ($type == "report_info"){
          $type = "text";
        }
        foreach($csv_path_data_list as $k => $csv_path_data){
          if (($row = search_pseudo_line($csv_path_data, $message[$login_sender_index])) != []){
            $profile_picture_index = get_collum_by_name($csv_path_data, "profile picture");
            $profile_picture = $row[$profile_picture_index];
          }
        }
        $is_empty = false;
        if ($message[$index_is_delete]){
          $content_message = "ce message a été supprimé";
          $type = "text";
        }
        if (in_array($sender_pseudo, $_SESSION['bloque'])){
          $sender_pseudo = "";
          $content_message = "ce message provient d'un utilisateur bloqué";
          $profile_picture = "";
          $type = "text";
        }
        create_message($nb_msg, $content_message, is_self_message($message[$login_sender_index]), $sender_pseudo, $profile_picture, $date,$type);
      }elseif ($message[$content_type_index] == "join_info"){
        create_info_text($message[$content_index], "--conv-join-info");
      }
      $nb_msg++;
    }
  }
  if ($is_empty){
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
