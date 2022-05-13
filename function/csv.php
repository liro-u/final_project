<?php
function get_collum_by_name($csv_path, $collum_name){
  if (($handle = fopen("csv_path", "r")) !== FALSE) {
    if (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
      foreach ($data as $key => $value){
        if ($value == $collum_name){
          fclose($handle);
          return $key;
        }
      }
    }
  }
  fclose($handle);
}
 ?>