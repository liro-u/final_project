<?php
echo "<style>";
include 'grid.css';
echo "</style>";
echo "<script>";
include "grid.js";
echo "</script>";

function create_grid_with_name($csv_path, $name_list, $remove_path = '""', $edit_path = '""', $add_path='""', $data_path = ""){
  $list_idx = [];
  foreach($name_list as $k => $name){
    if (($new_idx = get_collum_by_name($csv_path, $name)) != -1){
      $list_idx[] = $new_idx;
    }
  }
  $tab = get_content_in_array($csv_path);
  array_shift($tab);
  $csv_path = $data_path.$csv_path;
  echo("<table class='--grid-table' data-csvpath='$csv_path' data-edit=$edit_path data-del=$remove_path><tr>");
  foreach($name_list as $k => $name){
    echo("<th class='--grid-title'>$name</th>");
  }
  echo("</tr>");
  foreach($tab as $k => $row){
    echo("<tr>");
    foreach($list_idx as $key => $idx){
      echo("<td class='--grid-case'>".$row[$idx]."</td>");
    }
    echo("<td class='--grid-case' onclick='edit_line(this, ".'"'.$csv_path.'"'.", $k, $edit_path)'><img class='--grid-icon' src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/OOjs_UI_icon_edit-ltr.svg/1024px-OOjs_UI_icon_edit-ltr.svg.png'></img></td>
    <td class='--grid-case' onclick='ask_delete_line(this, $k, $remove_path)'><img class='--grid-icon' src='http://cdn.onlinewebfonts.com/svg/img_216917.png'></img></td>
    </tr>");
  }
  echo("<tr>");
  foreach($list_idx as $key => $idx){
    echo("<td class='--grid-case --grid-case-no-border'></td>");
  }
  echo("<td class='--grid-case --grid-case-no-border'></td>");
  echo("<td class='--grid-case' onclick='add_row(this, $add_path, ".'"'.$csv_path.'"'.")'><img class='--grid-icon' src='https://cdn-icons-png.flaticon.com/512/32/32339.png'></img></td></tr></table>");
}
 ?>
