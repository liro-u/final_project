<!--
on affiche que les messages qui ne sont pas supprimé
on creer un message selon le type (photo, fichier, texte)
-->
<?php
$conversation_path = $_GET["conv"];
$content_type = $_GET["content_type"];
$content = $_GET["content"];
include "../../../../function/csv.php";
echo get_collum_by_name($conversation_path, "hour");

 ?>