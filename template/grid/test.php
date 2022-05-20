<!DOCTYPE html>
<html data-scroll="0" lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../css/master.css">
  <?php
  session_start();
  include "../../content/connexion/verif_is_connected.php";
  verif_can_access(["admin", "administration"], "../../");
  include "grid_func.php";
  include "../../function/csv.php";
  include "../footer/footer.php";
  include "../nav_bar/nav_bar.php";
   ?>
  <title>Document</title>
</head>
<body>
<header>
<?php
add_menu_from_csv("../../data/".$_SESSION['type_user']."/menu.csv", "CY-Tech", "../../content/conversation/conversation/conv_template.php", "../../");
 ?>
</header>
<main>
  <div class="div_exemple"><div class="--grid-wrap">
    <?php
    echo("<h2 class='--grid-h2'>Etudiant parcours 1</h2>");
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours1.csv", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "Choix 1", "Choix 2", "Choix 3", "Choix 4", "Choix 5", "Choix 6", "Choix 7", "Choix 8", "attributed option"]);
    echo("<h2 class='--grid-h2'>Etudiant parcours 2</h2>");
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours2.csv", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "Choix 1", "Choix 2", "attributed option"]);
    echo("<h2 class='--grid-h2'>Etudiant parcours 3</h2>");
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours3.csv", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "Choix 1", "Choix 2", "Choix 3", "Choix 4", "Choix 5", "Choix 6", "attributed option"]);
    echo("<h2 class='--grid-h2'>administration</h2>");
    create_grid_with_name("../../data/administration/data.csv", ["prenom", "nom", "pseudo", "profile picture", "birth date", "adress"]);
    echo("<h2 class='--grid-h2'>admin</h2>");
    create_grid_with_name("../../data/admin/data.csv", ["prenom", "nom", "pseudo", "profile picture", "birth date", "adress"]);
    ?>
  </div></div>
</main>
<?php
add_default_footer();
 ?>
</body></html>
