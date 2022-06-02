<!DOCTYPE html>
<html data-scroll="0" lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Acceuil</title>
    <?php 
    session_start();
    include "content/connexion/verif_is_connected.php";
    verif_can_access();
    include "function/csv.php";
    include "template/nav_bar/nav_bar.php";
    include "template/footer/footer.php";
    include "template/grid/grid_func.php";
    ?>
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body>
    <header>
      <?php
      add_menu_from_csv("data/".$_SESSION['type_user']."/menu.csv", "CY-Tech");
      ?>
    </header>
    <main>
      <div class="div_exemple">
        <?php
        if ($_SESSION['type_user'] == "administration") {
       
          echo " <h1>Bienvenue ".$_SESSION['pseudo']."</h1> ";
          echo "<p> Bienvenue sur la page d'admin.
          Ici vous pouvez initialisez lancer la répartition des élèves dans leur futur filières et accéder à la liste des étudiants dans l'onglet fichier ! fin administration
          </p>";
 
        }
 
        if ($_SESSION['type_user'] == "etudiant") {
          echo " <h1>Bienvenue ".$_SESSION['pseudo']."</h1> ";
          echo "<p> L'equipe cy-tech vous informe qu'ici vous pourrez choisir vos voeux de filière.
          Pour cela cliquez sur choisir mes options et suivez la procédure
          <br> Remplissez votre profil !
          <br>Vous pouvez chosir photo de profils, date de naissance etc !! Fin étudiants
          </p>";
        }
 
        if ($_SESSION['type_user'] == "admin") {
 
          echo " <h1>Bienvenue ".$_SESSION['pseudo']."</h1> ";
         echo "<p> Bienvenue sur la page administrateur.
         Ici vous pouvez attribuer des mots de passe à chaque étudiants
         Vous pouvez aussi acceder à la liste des étudiants ainsi qu'à celle de l'admistrations.
         Gérer les conversations !
         En cas d'alerte vous pouvez résoudre les problèmes en supprimant certains messages
          </p>";
        }

      echo "</div>";
      echo "<img class='gif' src='https://media.giphy.com/media/dZXzmKGKNiJtDxuwGg/giphy.gif'>";
    echo"</main>";
    add_default_footer();
     ?>
 
  </body>
</html>
