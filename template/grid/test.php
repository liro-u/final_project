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
add_menu_from_csv("../../data/".$_SESSION['type_user']."/menu.csv", "CY-Tech", "../../");
 ?>
</header>
<main>
  <div class="div_exemple"><div class="--grid-wrap">
    <?php
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours1.csv", "etudiant GSI", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "pseudo bloquee", "Choix 1", "Choix 2", "Choix 3", "Choix 4", "Choix 5", "Choix 6", "Choix 7", "Choix 8", "attributed option"]);
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours2.csv", "etudiant MF", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "Choix 1", "pseudo bloquee", "Choix 2", "attributed option"]);
    create_grid_with_name("../../data/etudiant/choixEtudiantsParcours3.csv", "etudiant MI", ["prenom", "nom", "pseudo", "password", "login", "ECTS acquis", "Moyenne", "profile picture", "birth date", "adress", "Choix 1", "pseudo bloquee", "Choix 2", "Choix 3", "Choix 4", "Choix 5", "Choix 6", "attributed option"]);
    create_grid_with_name("../../data/administration/data.csv", "administration", ["prenom", "nom", "pseudo", "profile picture", "birth date", "adress", "pseudo bloquee"]);
    create_grid_with_name("../../data/admin/data.csv", "admin", ["prenom", "nom", "pseudo", "profile picture", "birth date", "adress", "pseudo bloquee"]);
    create_grid_with_name("../../data/mariage/nbPLacesParcours.csv", "repartition option par filiere", ["option", "GSI", "MI", "MF"]);
    create_grid_with_name("../../data/option_group/group.csv", "option group", ["option", "ACTU", "HPDA", "BI", "CS", "DS", "FT", "IAC", "IAP", "ICC", "INEM", "MMF", "VISUA"]);
    ?>
  </div></div>
</main>
<?php
add_default_footer();
 ?>
</body></html>
