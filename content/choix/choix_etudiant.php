<!DOCTYPE html>
<html data-scroll="0" lang="fr">
<head>
    <?php
    session_start();
    include "../../function/csv.php";
    include "../../content/connexion/verif_is_connected.php";
    verif_can_access(["admin", "administration", "etudiant"], "../../");
    include "../../template/footer/footer.php";
    include "../../template/nav_bar/nav_bar.php";
    ?>
    <meta charset="UTF-8">
    <link href="../../css/master.css" rel="stylesheet">
    <link href="stylechoix.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header>
<?php
add_menu_from_csv("../../data/".$_SESSION['type_user']."/menu.csv", "CY-Tech", "../../");
 ?>
</header>
<main>


<?php
$csv_path_etudiant1 = "../../data/etudiant/choixEtudiantsParcours1.csv";
$csv_path_etudiant2 = "../../data/etudiant/choixEtudiantsParcours2.csv";
$csv_path_etudiant3 = "../../data/etudiant/choixEtudiantsParcours3.csv";
//changer 
$chemin = is_in_witch_file("pseudo", $_SESSION['pseudo'],[$csv_path_etudiant1,$csv_path_etudiant2,$csv_path_etudiant3]);
$_SESSION["chemin"] = $chemin;
$open = fopen("$chemin", "r");
$ligne = fgetcsv($open, 1000, ";");
if (in_array("Choix 8", $ligne)){
    $a = "GSI";
}elseif (in_array("Choix 6", $ligne)){
    $a = "MI";
}elseif (in_array("Choix 2", $ligne)){
    $a = "MF";
}

echo "<h1>Classement des choix pour $a </h1>";
$_SESSION["otpion"] = $a;
echo "<h4> Voici votre liste de choix d'option : </h4>";
echo"
<br> <br>
<div class='table'>
<form action='choix_verif.php' method='post'>
<table>
    <tr>
        <th>Classement de Choix</th>
        <th>Option</th>
    </tr>
";

function get_array_option($nb, $chemin){
    $row = search_in_file_at_same_line($chemin, [$_SESSION['pseudo']], ["pseudo"]);
    $list = [];
    for($i = 0; $i < $nb; $i++){
        $idx = get_collum_by_name($chemin, "Choix ".($i + 1));
        $list[] = $row[$idx];
    }
    return $list;
}

function print_option($nb, $list_option, $my_list){
    echo"<tr>";
    echo"<th>$nb</th>";
    echo"<td>";
    echo"<select name='select".$nb."'>";
    foreach($list_option as $k => $v){
        $compl = "";
        if ($v == str_replace(" ", "", $my_list[$nb - 1])){
            $compl = ' selected="selected"';
        }
        echo"<option name='$v'$compl>$v</option>";
    }

    echo"</select>";
    echo"</td>";
    echo"</tr>";
}

if ($a == 'MF') {
    $list_option = ["Actu", "MMF"];
    $list = get_array_option(2, $chemin);
    for($j = 1; $j <= 2; $j++){
        print_option($j, $list_option, $list);
    }
}



if ($a == "MI") {
    $list_option = ["HPDA", "BI", "DS", "FT", "IAC", "IAP"];
    $list = get_array_option(6, $chemin);
    for($j = 1; $j <= 6; $j++){
        print_option($j, $list_option, $list);
    }
}


if ($a == "GSI") {
    $list_option = ["HPDA", "BI", "CS", "IAC", "IAP", "ICC", "INEM", "VISUA"];
    $list = get_array_option(8, $chemin);
    for($j = 1; $j <= 8; $j++){
        print_option($j, $list_option, $list);
    }
}

echo"
</table>
<a href='../../test.php'>
<input type='button' value='Annuler' class='bouton'></a>
<input type='submit' value='Envoyer' class='bouton' >
</form>
</div>
";
?>
</body>
</main>
<?php
add_default_footer("../../");
 ?>
</html>
