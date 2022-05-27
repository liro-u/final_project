<?php
include "../../../function/csv.php";
session_start();
$pseudo = $_GET['pseudo'];
$name_groupe = $_GET['name_groupe'];
$user = $_SESSION["pseudo"];
//verif conv data name dosnt exist, if exist add number and reverif
//create conv data csv first line (login_sender;date;content_type;content;is_delete;delete_date)

//verif conv info name downt exist, if exist add number and reverif
//create conv info first line(name;adress;"pseudo list")
//fill with data (name_groupe;data name;"")

//add to group pseudo
//add to group user

?>