<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">

    <title>initialiser les comptes</title>
      <?php
      session_start();
      include "../../content/connexion/verif_is_connected.php";
      verif_can_access(["admin", "administration"], "../../")
     ?>
  </head>
  <body>
      <?php
      include "init_session.php";
      $csv_etudiant1 = "../../data/etudiant/choixEtudiantsParcours1.csv";
      $csv_etudiant2 = "../../data/etudiant/choixEtudiantsParcours2.csv";
      $csv_etudiant3 = "../../data/etudiant/choixEtudiantsParcours3.csv";
      $csv_administration = "../../data/administration/data.csv";
      $csv_admin = "../../data/admin/data.csv";
      $csv_profile_picture = "../../data/admin/asset/profile_picture.csv";
      init_session($csv_etudiant1, [$csv_administration, $csv_admin, $csv_etudiant2, $csv_etudiant3], $csv_profile_picture);
      init_session($csv_etudiant2, [$csv_administration, $csv_admin, $csv_etudiant1, $csv_etudiant3], $csv_profile_picture);
      init_session($csv_etudiant3, [$csv_administration, $csv_admin, $csv_etudiant1, $csv_etudiant2], $csv_profile_picture);
      init_session($csv_admin, [$csv_administration, $csv_etudiant2, $csv_etudiant1, $csv_etudiant3], $csv_profile_picture);
      init_session($csv_administration, [$csv_etudiant1, $csv_admin, $csv_etudiant2, $csv_etudiant1], $csv_profile_picture);
      header('location: ../../index.php');
       ?>
  </body>
</html>
