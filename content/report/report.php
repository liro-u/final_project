<!DOCTYPE html>
<html lang="fr">
<head>
  <?php
  include "../../template/footer/footer.php";
  ?>
  <meta charset="UTF-8">
  <title>reporter un problème</title>
  <link rel="stylesheet" href="../../css/master.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <form action="make_report.php" method="post">
    <h1>Motif de signalement </h1>
    <input class="text_input input" type="text" required name="motif">
    <h1>Entrer un descriptif</h1>
    <textarea cols="40" rows="15" placeholder="je fait un report pour le motif suivant ... " name="description" required></textarea>
    <a href="../../index.php">
    <input type="button" value="Annuler" class='button input'> </a>
    <input type="submit" value="Envoyer" class="button input">
    </from>
  </main>
  <?php
  add_default_footer("../../");
  ?>
</body>
</html>