<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../css/master.css">
  <?php
  include "grid_func.php";
  include "../../function/csv.php"
   ?>
  <script src="conversation.js" defer></script>
  <title>Document</title>
</head>
<body>

<div class="div_exemple">
  <?php
  create_grid_with_name("../../data/etudiant/data.csv", ["nom", "prenom", "profile picture", "password"]);
  ?>
</div>
</body></html>