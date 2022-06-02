<!DOCTYPE html>
<html>
<head>
    <title>Conv Manager</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/master.css"/>
    <link rel="stylesheet" type="text/css" href="conv_manager.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script type="text/javascript" src="addConv.js" defer></script>
    <?php
    session_start();
    include "../../../content/connexion/verif_is_connected.php";
    verif_can_access(["administration", "admin", "etudiant"], "../../../");
    include "conv_loader.php";
     ?>
</head>
<body>
<div class="--conv-add-conv-popuptext" id="conv_popup">
  <div class="--conv-add-conv-text">
    <div class="--conv-form-text">
      <label class='--conv-label'>Ajouter une personne</label><input id="pseudo" class="--conv-input-text" type="text" name="Pseudo" value=""/>
      <button id="submit_ajouter" class="--conv-submit" onclick="add_to_group()">ajouter</button>
    </div>
  </div>
</div>
<div class="--conv-add-grp-popuptext" id="group_popup">
  <div class="--conv-add-grp-text">
    <div class="--conv-form-grp-text">
      <label class='--conv-label'>Nom du groupe</label><input id="name_group" class="--conv-input-text" type="text" name="groupe" value=""/>
      <label class='--conv-label'>Ajouter une personne</label><input id="pseudo_group" class="--conv-input-text" type="text" name="Pseudo" value=""/>
      <button id="submit_creer" class="--conv-submit" onclick="create_conv()">creer</button>
    </div>
  </div>
</div>

<div class="sidenav">
    <div class="side_1">
        <a class="tab_link side_first"  href="conv_manager.php?state=conversation">Conversation</a>
        <i class="fa plusIcon" onclick='ShowaddConv()'>&#xf067;</i>
    </div>
    <div class="side_1"><a class="tab_link" href="conv_manager.php?state=notification">Notification</a></div>
    <div class="side_1"><a class="tab_link" href="conv_manager.php?state=admin">Admin</a></div>
    <a class="c_m_return_link" href="../../../index.php">
      <img class="c_m_return_img"src="https://cdn-icons-png.flaticon.com/512/709/709586.png">
    </a>
</div>
<div class="content">
    <table class="table table-hover v-middle mb-0 font-14">
        <tbody>
          <?php
          load_profile_conv();
          ?>
        </tbody>
    </table>
</div>
</body>
</html>
