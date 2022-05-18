<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../../css/master.css">
  <link rel="stylesheet" href="conv.css">
  <?php
  session_start();
  include "../../../content/connexion/verif_is_connected.php";
  include "conv_php/conv_func.php";
   ?>
  <script src="conversation.js" defer></script>
  <title>les bg de la campagne</title>
</head>
<body>
  <header class="--conv-header">
    <a class="--conv-link-return" href="../../../test.php"><img class="--conv-return" src="https://cdn-icons-png.flaticon.com/512/709/709586.png" alt="return"></img></a>
    <p class="--conv-name-labbel">les bg de la campagne</p>
    <img class="--conv-i-img" src="https://icon-library.com/images/information-icon-white/information-icon-white-6.jpg" alt="info_img"></img>
  </header>
  <main class="--conv-message-container">
    <?php
    show_conv("../../../data/conversation.csv", ["../../../data/admin/data.csv", "../../../data/administration/data.csv", "../../../data/etudiant/data.csv"]);
     ?>
  </main>
  <footer class="--conv-footer">
    <div class="--conv-wrap-icon">
      <img class="--conv-icon-footer" onclick="toggle_galerie_mode(this)" src="https://cdn-icons-png.flaticon.com/512/833/833281.png" alt="icon_galerie"></img>
    </div>
    <div class="--conv-text-input">
      <input type="text" id="--conv-input-message-text" class="--conv-input-text" name="message_input" minlength="0" maxlength="360" placeholder="Aa">
      <img class="--conv-send-icon" src="https://iconape.com/wp-content/files/xh/367685/svg/send-logo-icon-png-svg.png" alt="send_icon" onclick="send_message()"></img>
    </div>
  </footer>
</body>
</html>

<!--
  3 point mal placé verticalement sur les petits messages
-->
