<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>test</title>
    <?php
    include "mariage.php";
     ?>
  </head>
  <body>
    <?php
    make_mariage("../../data/etudiant/choixEtudiantsParcours1.csv", "GSI");
    make_mariage("../../data/etudiant/choixEtudiantsParcours2.csv", "MF");
    make_mariage("../../data/etudiant/choixEtudiantsParcours3.csv", "MI");
    header('location: ../../index.php');
     ?>
  </body>
</html>
