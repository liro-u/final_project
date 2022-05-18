<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    
    <title>test</title>
  </head>
  <body>
      <?php
      include "init_session.php";
      $csv_etudiant = "../../data/etudiant/data.csv";
      $csv_administration = "../../data/administration/data.csv";
      $csv_admin = "../../data/admin/data.csv";
      $csv_profile_picture = "../../data/admin/asset/profile_picture.csv";
      init_session($csv_etudiant, [$csv_administration, $csv_admin], $csv_profile_picture);
      init_session($csv_admin, [$csv_administration, $csv_etudiant], $csv_profile_picture);
      init_session($csv_administration, [$csv_etudiant, $csv_admin], $csv_profile_picture);
      header('location: ../../index.php');
       ?>
  </body>
</html>
