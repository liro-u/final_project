<?php
function get_collum_by_name($csv_path, $collum_name){
  if (($handle = fopen($csv_path, "r")) !== FALSE) {
    if (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
      foreach ($data as $key => $value){
        if ($value == $collum_name){
          fclose($handle);
          return $key;
        }
      }
    }
    fclose($handle);
  }
  return -1;
}

function getSizeFirstLine($csv_path){
  $nbCol = -1;
  if (($handle = fopen($csv_path, "r")) !== FALSE) {
    if (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
      $nbCol = count($data);
    }
    fclose($handle);
  }
  return $nbCol;
}

function get_content_in_array($csv_path){
  $tab = [];
  if (($handle = fopen($csv_path, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
          $tab[] = $data;
      }
      fclose($handle);
  }
  return $tab;
}

function add_row_from_array($csv_path, $data){
  if (($handle = fopen($csv_path, "a")) !== FALSE) {
    fputcsv($handle, $data, ";");
    fclose($handle);
  }
}

function replace_csv_by_array($csv_path, $tab){
  if (($handle = fopen($csv_path, "w+")) !== FALSE) {
    foreach ($tab as $data) {
        fputcsv($handle, $data, ";");       
    }
    fclose($handle);
  }
}

function match_tab_row_size($tab){
  $copy_tab = $tab;
  $first_line = array_shift($copy_tab);
  foreach($first_line as $key => $value){
    foreach($copy_tab as $k => $row){
      if (! array_key_exists($key, $row)){
        $tab[$k + 1][$key] = "";
      }
    }
  }
  return $tab;
}

function exist_in_collum_name($name, $research, $csv_path_list){
  foreach($csv_path_list as $k => $csv_path){
    $tab = get_content_in_array($csv_path);
    if (exist_in_collum_name_array($name, $research, $csv_path, $tab)){
      return true;
    }
  }
  return false;
}

function exist_in_collum_name_array($name, $research, $csv_path, $tab){
  $idx = get_collum_by_name($csv_path, $name);
  if ($idx != -1){
    array_shift($tab);
    foreach($tab as $key => $row){
      if ($row[$idx] == $research){
        return true;
      }
    }
  }
  return false;
}

function get_random_row($csv_path){
  $no_message_list = get_content_in_array($csv_path);
  return $no_message_list[array_rand($no_message_list, 1)];
}

function search_in_file_at_same_line($csv_path, $param_list, $idx_name_list){
  foreach($idx_name_list as $k => $name){
    $idx_list[] = get_collum_by_name($csv_path, $name);
  }

  if (($handle = fopen($csv_path, "r")) !== FALSE) {
    if (($data = fgetcsv($handle, 1000, ";")) !== FALSE){
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $is_correct = true;
        foreach($idx_list as $k => $idx){
          $is_correct = ($is_correct and ($data[$idx] == $param_list[$k]));
        }
        if ($is_correct){
          return $data;
        }
      }
    }
    fclose($handle);
  }
  return NULL;
}

function remove_line($csv_path, $line){
  $tab = get_content_in_array($csv_path);
  unset($tab[$line]);
  replace_csv_by_array($csv_path, $tab);
}
function search_pseudo_line($csv_path, $pseudo){
  $idx_pseudo = get_collum_by_name($csv_path, "pseudo");
  $tab = get_content_in_array($csv_path);
  foreach($tab as $k => $row){
    if ($row[$idx_pseudo] == $pseudo){
      return $row;
    }
  }
  return [];
}
 ?>

