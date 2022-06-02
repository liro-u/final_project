<?php
include "../../function/csv.php";
session_start();

$post_select1 = $_POST["select1"];
$post_select2 = $_POST["select2"];
$liste = [$post_select1, $post_select2];
if ($_SESSION["otpion"] != "MF"){
    $post_select3 = $_POST["select3"];
    $post_select4 = $_POST["select4"];
    $post_select5 = $_POST["select5"];
    $post_select6 = $_POST["select6"];
    array_push($liste, $post_select3, $post_select4, $post_select5, $post_select6);
    if($_SESSION["otpion"] != "MI"){
        $post_select7 = $_POST["select7"];
        $post_select8 = $_POST["select8"];
        array_push($liste, $post_select7, $post_select8);
    }
}

    if (count(array_unique($liste)) == count($liste)) {
        $ligne = search_pseudo_line_key($_SESSION["chemin"], $_SESSION['pseudo']);
        $content = get_content_in_array($_SESSION["chemin"]);
        $index_post1 = get_collum_by_name($_SESSION["chemin"], "Choix 1");
        $content[$ligne][$index_post1] = $post_select1;
        replace_csv_by_array($_SESSION["chemin"], $content);

        $index_post2 = get_collum_by_name($_SESSION["chemin"], "Choix 2");
        $content[$ligne][$index_post2] = $post_select2;
        replace_csv_by_array($_SESSION["chemin"], $content);

        if ($_SESSION["otpion"] != "MF"){
            $index_post3 = get_collum_by_name($_SESSION["chemin"], "Choix 3");
            $content[$ligne][$index_post3] = $post_select3;
            replace_csv_by_array($_SESSION["chemin"], $content);

            $index_post4 = get_collum_by_name($_SESSION["chemin"], "Choix 4");
            $content[$ligne][$index_post4] = $post_select4;
            replace_csv_by_array($_SESSION["chemin"], $content);

            $index_post5 = get_collum_by_name($_SESSION["chemin"], "Choix 5");
            $content[$ligne][$index_post5] = $post_select5;
            replace_csv_by_array($_SESSION["chemin"], $content);

            $index_post6 = get_collum_by_name($_SESSION["chemin"], "Choix 6");
            $content[$ligne][$index_post6] = $post_select6;
            replace_csv_by_array($_SESSION["chemin"], $content);

            if ($_SESSION["otpion"] != "MI"){
                $index_post7 = get_collum_by_name($_SESSION["chemin"], "Choix 7");
                $content[$ligne][$index_post7] = $post_select7;
                replace_csv_by_array($_SESSION["chemin"], $content);

                $index_post8 = get_collum_by_name($_SESSION["chemin"], "Choix 8");
                $content[$ligne][$index_post8] = $post_select8;
                replace_csv_by_array($_SESSION["chemin"], $content);
            }
        }

        header("location: ../../test.php");
      
    }else {
        header("location: choix_etudiant.php");
    }
?>