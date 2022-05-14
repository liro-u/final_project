<?php
include "../../../function/csv.php";

function create_info_text($info, $class){
  echo("<div class='--conv-wrap-part-conv $class'>");
  echo("<p class='--conv-info-text'>");
  echo($info);
  echo("</p></div>");
}

function create_message($content, $self = true, $content_type = "text"){
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
  echo('<p class="--conv-message">');
  if ($content_type == "text"){
    echo($content);
  }
  echo('</p></div>');
  if (! $self){
    add_3_point();
  }
  echo('</div>');
}

function add_3_point(){
  echo('<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>');
}

function show_conv($conv_path){
  $content_conv = get_content_in_array($conv_path);
  array_shift($content_conv);
  $content_index = get_collum_by_name($conv_path, "content");
  $content_type_index = get_collum_by_name($conv_path, "content_type");
  $login_sender_index = get_collum_by_name($conv_path, "login_sender");
  if (count($content_conv) > 0){
    foreach ($content_conv as $key => $message) {
      create_message($message[$content_index], is_self_message($message[$login_sender_index]), $message[$content_type_index]);
    }
  }else{
    create_info_text(get_random_row("../../../data/conversation/style/no_message.csv")[0], "no_message");
  }
}

function is_self_message($login_sender){
  return true;
}
 ?>
