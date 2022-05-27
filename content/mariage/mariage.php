<?php
include "../../function/csv.php";

function make_mariage($csv_path, $name_filiere, $save_mode = "add", $option_group_path = "../../data/option_group/group.csv", $filiere_path = "../../data/mariage/nbPLacesParcours.csv"){
  //create file for option group
  if ($save_mode == "new"){
    //delete and create data option group file
    $handle = fopen($option_group_path, "w");
    fclose($handle);
    //get option name
    $index_option = get_collum_by_name($filiere_path, "option");
    $option_names = [["option"]];
    $option_names[1] = ["nombre d'eleve"];
    $option_names[2] = ["moyenne de la moyenne"];
    $option_names[3] = ["moyenne du dernier admis"];
    $filiere_content = get_content_in_array($filiere_path);
    foreach($filiere_content as $key => $row){
      $option_names[0][] = $row[$index_option];
      $option_names[1][] = "x";
      $option_names[2][] = "x";
      $option_names[3][] = "x";
    }
    array_shift($option_names[0]);
    //save option name in file
    replace_csv_by_array($option_group_path, $option_names);
  }
  //create variable for nb line of data who is note studdent
  $line_offset = 4;
  //index studdent
  $index_pseudo = get_collum_by_name($csv_path, "pseudo");
  $index_moyenne = get_collum_by_name($csv_path, "Moyenne");
  //get content of data studdent
  $content_csv = get_content_in_array($csv_path);
  array_shift($content_csv);
  //keep just usefull part
  $tab = [];
  foreach ($content_csv as $key => $row) {
    $tab[$row[$index_pseudo]] = $row[$index_moyenne];
  }
  //sort tab by average mark
  arsort($tab, SORT_NUMERIC);
  foreach ($tab as $key => $value) {
    $sort_pseudo[] = $key;
  }

  //index option
  $index_filiere = get_collum_by_name($filiere_path, $name_filiere);
  $index_option = get_collum_by_name($filiere_path, "option");
  //get content of data filiere
  $filiere_content = get_content_in_array($filiere_path);
  array_shift($filiere_content);
  //keep usefull part
  $option_name = [];
  foreach ($filiere_content as $key => $row) {
    if ($row[$index_filiere] != 0){
      $option_name[$row[$index_option]] = $row[$index_filiere];
    }
  }
  //create preference tab for filiere
  $option_preference = [];
  foreach ($option_name as $name => $place) {
  $option_preference[$name] = ["preference" => $sort_pseudo, "engaged_with" => [], "place_before_engaged" => $place];
  }
  

  //get studdent preference
  $index_choix = [];
  $i = 0;
  foreach ($option_name as $key => $value) {
    $i++;
    $index_choix[] = get_collum_by_name($csv_path, "Choix ".$i);
  }
  //create preference tab for studdent
  $studdent_prefference = [];
  foreach ($content_csv as $key => $row) {
    foreach ($index_choix as $k => $index) {
      $studdent_prefference[$row[$index_pseudo]]["preference"][$k] = str_replace(' ', '', $row[$index]);
    }
    $studdent_prefference[$row[$index_pseudo]]["engaged_with"] = null;
  }


  //boucle while all studdent is engaged
  do{
    $all_is_engaged = true;
    foreach($studdent_prefference as $pseudo => $data){
      //check if studdent is already engaged
      if($data["engaged_with"] == null){
        $all_is_engaged = false;
        //get first choice of the student
        $option_name = array_shift($studdent_prefference[$pseudo]["preference"]);
        $option_data = $option_preference[$option_name];
        //check if the choice is engaged
        if (count($option_data["engaged_with"]) < $option_data["place_before_engaged"]){
          //engaged with the studdent
          $option_preference[$option_name]["engaged_with"][] = $pseudo;
          $studdent_prefference[$pseudo]["engaged_with"] = $option_name;
        }else{
          //check if the studdent is best for the option
          $worst_studdent = $pseudo;
          foreach($option_preference[$option_name]["engaged_with"] as $key => $studdent_of_option){
            if ($tab[$studdent_of_option] < $tab[$worst_studdent]){
              $worst_studdent = $studdent_of_option;
            }
          }
          if ($worst_studdent != $pseudo){
            //free the worst studdent from the option list and make him non engaged
            $studdent_prefference[$worst_studdent]["engaged_with"] = null;
            $key = array_search($worst_studdent, $option_preference[$option_name]["preference"]);
            unset($option_preference[$option_name]["preference"][$key]);
            //engaged with the studdent
            $option_preference[$option_name]["engaged_with"][] = $pseudo;
            $studdent_prefference[$pseudo]["engaged_with"] = $option_name;
          }
        }
        //delete the pseudo from the option list
        $key = array_search($pseudo, $option_preference[$option_name]["preference"]);
        unset($option_preference[$option_name]["preference"][$key]);
        //delete the option from the studdent list
        $key = array_search($option_name, $studdent_prefference[$pseudo]["preference"]);
        unset($studdent_prefference[$pseudo]["preference"][$key]);
      }
    }
  }while(! $all_is_engaged);

  //add assigned_option to data student
  $final_tab = get_content_in_array($csv_path);
  $index_attributed_option = get_collum_by_name($csv_path, "attributed option");
  $index_pseudo = get_collum_by_name($csv_path, "pseudo");
  foreach($final_tab as $key => $row){
    if ($key > 0){
      $final_tab[$key][$index_attributed_option] = $studdent_prefference[$row[$index_pseudo]]["engaged_with"];
    }
  }
  //save new data in studdent data
  replace_csv_by_array($csv_path, $final_tab);
  //save new data group
  $option_group_content = get_content_in_array($option_group_path);
  foreach($option_preference as $option_name => $option_data){
    //get index of option
    $index_option = get_collum_by_name($option_group_path, $option_name);
    $index_collum_name = get_collum_by_name($option_group_path, "option");
    $line_nb = 0;
    //get last line of collum index
    while(isset($option_group_content[$line_nb]) and $option_group_content[$line_nb][$index_option] != ""){
      $line_nb++;
    }
    //add pseudo to tab
    foreach ($option_data["engaged_with"] as $key => $pseudo){
      $option_group_content[$line_nb][$index_option] = $pseudo;
      $line_nb++;
    }
    //put nb studdent / option
    $option_group_content[1][$index_option] = $line_nb - $line_offset +1;
    //make all line with same number of collum
    $option_group_content = match_tab_row_size($option_group_content);
    foreach($option_group_content as $key => $value ){
      ksort($option_group_content[$key], SORT_NUMERIC);
    }
  }
  //calcul moyenne for all studdent in each option

  //search the worst studdent moyenne for each option

  replace_csv_by_array($option_group_path, $option_group_content);

  #######################################################################################################################################
  //create group data csv file if we have time ##########################################################################################
  #######################################################################################################################################

  //show result of the sorting--------------------------------------------------
  /*
  //printing option groupe
  foreach($option_preference as $key => $option){
    echo("<br><br>".$key."<br>");
    print_r($option["engaged_with"]);
  }
  echo("<br><br>");
  //printing student option
  foreach($studdent_prefference as $key => $pseudo){
    echo("<br>".$key." - ".$pseudo["engaged_with"]);
  }
  */
  //----------------------------------------------------------------------------
}
 ?>
