<!DOCTYPE html>
<html data-scroll="0" lang="fr">
  <head>
    <?php
    session_start();
    include "../../content/connexion/verif_is_connected.php";
    verif_can_access();
    include "../../template/nav_bar/nav_bar.php";
    include "../../template/footer/footer.php";
    ?>
    <meta charset="utf-8">
    <link href="../../css/master.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <title>Settings</title>
  </head>
  <body>
  <header>
      <?php
      add_menu_from_csv("../../data/".$_SESSION['type_user']."/menu.csv", "CY-Tech", "../../");
      ?>
  </header>
  <main>
    <?php
    $date = explode('/', $_SESSION['anniversaire']);
    if ($date[0] == ""){
      $date = explode("/", date("j/m/Y", time()));
    }
    ?>
    <h3 style="text-align : center;"> Réglages du profil </h2><br>
  <div>
    <form action="verif_modif_profil.php" method="post">
      <h4> Modifier la date de naissance </h4>
      <?php
       echo "<fieldset class='jour' >";
        echo "<legend style='margin-left: 2%; padding: 5px; font-size:15px'>Jour</legend>";
        echo "<input type='number' max='31' class='input' name='jour' value=$date[0] style='width:40px; border: 0'>";
      echo "</fieldset>";
        echo "<fieldset class='mois' >";
          echo "<legend style='margin-left: 2%; padding: 5px; font-size:15px'>Mois</legend>";
          echo "<input type='number' max='12' class='input' name='mois' value=$date[1] style='width:40px; border: 0'>";
        echo "</fieldset>";
        echo "<fieldset class='annees'>";
          echo "<legend style='margin-left: 2%; padding: 5px ; font-size:15px '>Années</legend>";
          echo "<input type='number' class='input' name='annee' value=$date[2] style='width:60px; border: 0;'>";
        echo "</fieldset> <br> <br> <br>";
      ?>

        <table>
          <!--
          <td colspan="2"> Pseudo </td>

            <tr>
              <th> Pseudo </th>
              <?php
              echo "<td> <input type='pseudo' class='input' name='pseudo' autocomplete='off'  value='".$_SESSION['pseudo']."'> </td>"
              ?>
            </tr>
  -->
        <td colspan="2"> Mot de Passe </td>

          <tr>
            <th> Mot de Passe </th>
            <td> <input type="password" class='input' autocomplete="off" name="password2"> </td>
          </tr>

          <tr>
            <th> Nouveau Mot de passe </th>
            <td> <input type="password" class='input' name="password3"> </td>
          </tr>

          <tr>
            <th> Confirmez votre mot de passe </th>
            <td> <input type="password" class='input' name="password4"> </td>
          </tr>

        <td colspan="2"> Modifier son adresse postale </td>

        <tr>
          <th> Adresse Postale</th>
          <?php
          echo "<td> <input type='text' class='input' name='adresse' value='".$_SESSION['adresse']."'> </td>";
          ?>
        </tr>


      <td colspan="2"> Image de profil </td>

      <tr>
          <th> Entrez un lien d'image</th>
          <td> <input type="text" class='input' name="photo"> </td>
        </tr>


      </table>


  </div>

        <a href="../../../test.php">
        <input type="button" value="Annuler" class='input button'> </a>
        <input type="submit" value="Envoyer" class="button input">

    </from>

  </main>
  <?php
  add_default_footer("../../");
   ?>
  </body>
</html>
