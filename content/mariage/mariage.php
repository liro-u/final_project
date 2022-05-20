<?php
include "../../function/csv.php";

function make_mariage($csv_path, $name_filiere, $filiere_path = "../../data/mariage/nbPLacesParcours.csv"){
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
  }while($all_is_engaged);

  //add assigned_option to data student
  $final_tab = get_content_in_array($csv_path);
  $index_attributed_option = get_collum_by_name($csv_path, "attributed option");
  $index_pseudo = get_collum_by_name($csv_path, "pseudo");
  foreach($final_tab as $key => $row){
    if ($key > 0){
      $final_tab[$key][$index_attributed_option] = $studdent_prefference[$row[$index_pseudo]]["engaged_with"];
    }
  }

  replace_csv_by_array($csv_path, $final_tab);
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
